php artisan config:clear
php artisan cache:clear<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Todo SPA</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { color-scheme: light; font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { margin: 0; background: #f6f7fb; color: #111827; }
        .shell { max-width: 900px; margin: 0 auto; padding: 32px 20px 64px; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 10px 30px -12px rgba(0,0,0,0.15); }
        .flex { display: flex; }
        .between { justify-content: space-between; }
        .center { align-items: center; }
        .gap-12 { gap: 12px; }
        .gap-16 { gap: 16px; }
        .p-20 { padding: 20px; }
        .p-24 { padding: 24px; }
        .mt-16 { margin-top: 16px; }
        .mt-24 { margin-top: 24px; }
        .mt-32 { margin-top: 32px; }
        .mb-12 { margin-bottom: 12px; }
        .mb-16 { margin-bottom: 16px; }
        .mb-24 { margin-bottom: 24px; }
        .title { font-size: 28px; font-weight: 700; margin: 0; }
        .muted { color: #6b7280; }
        .btn { display: inline-flex; align-items: center; justify-content: center; border: 1px solid transparent; border-radius: 10px; padding: 10px 14px; font-weight: 600; cursor: pointer; transition: all 0.18s ease; text-decoration: none; }
        .btn.primary { background: #4f46e5; color: #fff; box-shadow: 0 10px 20px -12px rgba(79,70,229,0.6); }
        .btn.primary:hover { background: #4338ca; }
        .btn.ghost { background: #f3f4f6; color: #111827; border-color: #e5e7eb; }
        .btn.ghost:hover { background: #e5e7eb; }
        .btn.danger { background: #fef2f2; color: #b91c1c; border-color: #fecdd3; }
        .btn.danger:hover { background: #fee2e2; }
        .input, .textarea { width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: 10px 12px; font-size: 15px; outline: none; transition: border-color 0.15s ease, box-shadow 0.15s ease; }
        .input:focus, .textarea:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.12); }
        .textarea { min-height: 110px; resize: vertical; }
        .todo { border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; background: #fff; }
        .todo.done { opacity: 0.75; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; font-size: 13px; font-weight: 600; }
        .badge.green { background: #ecfdf3; color: #15803d; border: 1px solid #bbf7d0; }
        .badge.amber { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .small { font-size: 13px; }
        .divider { height: 1px; background: #e5e7eb; margin: 16px 0; }
        .list { display: grid; gap: 12px; }
    </style>
</head>
<body>
<div id="app" class="shell">
    <div class="flex between center mb-24">
        <div>
            <p class="muted mb-12" style="margin:0; font-size:14px;">Todo SPA (REST)</p>
            <h1 class="title">Your Todos</h1>
        </div>
        <div class="flex center gap-12">
            <button class="btn ghost" @click="logout" :disabled="loggingOut">
                @{{ loggingOut ? 'Logging out...' : 'Logout' }}
            </button>
            <button class="btn primary" @click="fetchTodos" :disabled="loading">
                @{{ loading ? 'Loading...' : 'Refresh' }}
            </button>
        </div>
    </div>

    <div class="card p-24">
        <h3 style="margin:0 0 12px 0; font-size:18px;">Add Todo</h3>
        <div class="flex gap-16">
            <input class="input" placeholder="Title" v-model="form.title" />
        </div>
        <div class="mt-12">
            <textarea class="textarea" placeholder="Description (optional)" v-model="form.description"></textarea>
        </div>
        <div class="mt-16 flex between center">
            <span class="muted small">POST /todos</span>
            <button class="btn primary" @click="createTodo" :disabled="creating || !form.title.trim()">
                @{{ creating ? 'Creating...' : 'Create' }}
            </button>
        </div>
    </div>

    <div class="mt-32">
        <div class="flex between center mb-12">
            <h3 style="margin:0; font-size:18px;">Items</h3>
            <span class="muted small">GET /todos</span>
        </div>
        <div v-if="todos.length" class="list">
            <div v-for="t in todos" :key="t.id" class="todo" :class="{ done: t.is_completed }">
                <div class="flex between center gap-12">
                    <div class="flex center gap-12">
                        <input type="checkbox" :checked="t.is_completed" @change="toggleTodo(t)" />
                        <div>
                            <div class="flex center gap-12">
                                <strong>@{{ t.title }}</strong>
                                <span class="badge" :class="t.is_completed ? 'green' : 'amber'">
                                    @{{ t.is_completed ? 'Done' : 'Pending' }}
                                </span>
                            </div>
                            <p v-if="t.description" class="muted" style="margin:6px 0 0 0;">@{{ t.description }}</p>
                            <p class="muted small" style="margin:6px 0 0 0;">Updated @{{ new Date(t.updated_at).toLocaleString() }}</p>
                        </div>
                    </div>
                    <div class="flex gap-12">
                        <button class="btn ghost" @click="promptEdit(t)">Edit</button>
                        <button class="btn danger" @click="deleteTodo(t)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="card p-20 muted">No todos yet. Create one above.</div>
    </div>

    <!-- Simple edit modal -->
    <div v-if="edit.open" style="position:fixed; inset:0; background:rgba(0,0,0,0.35); display:flex; align-items:center; justify-content:center; padding:20px;">
        <div class="card p-24" style="max-width:480px; width:100%;">
            <h3 style="margin:0 0 12px 0; font-size:18px;">Edit Todo</h3>
            <div class="mt-12">
                <input class="input" v-model="edit.title" />
            </div>
            <div class="mt-12">
                <textarea class="textarea" v-model="edit.description"></textarea>
            </div>
            <label class="flex center gap-12 mt-12">
                <input type="checkbox" v-model="edit.is_completed" />
                <span>Completed</span>
            </label>
            <div class="mt-16 flex between center">
                <button class="btn ghost" @click="closeEdit">Cancel</button>
                <button class="btn primary" @click="submitEdit" :disabled="updating || !edit.title.trim()">
                    @{{ updating ? 'Saving...' : 'Save' }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const { createApp, reactive, ref } = Vue;

function csrf() {
    const el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.getAttribute('content') : '';
}

const app = createApp({
    setup() {
        const todos = ref([]);
        const loading = ref(false);
        const creating = ref(false);
        const updating = ref(false);
        const loggingOut = ref(false);
        const form = reactive({ title: '', description: '' });
        const edit = reactive({ open: false, id: null, title: '', description: '', is_completed: false });

        const fetchTodos = async () => {
            loading.value = true;
            try {
                const res = await fetch('/todos', { headers: { 'Accept': 'application/json' } });
                if (!res.ok) throw new Error('Failed to fetch');
                todos.value = await res.json();
            } catch (e) {
                alert('Failed to load todos. Ensure you are logged in and MySQL is running.');
            } finally {
                loading.value = false;
            }
        };

        const createTodo = async () => {
            creating.value = true;
            try {
                const res = await fetch('/todos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ title: form.title, description: form.description }),
                });
                if (!res.ok) throw new Error('Create failed');
                form.title = '';
                form.description = '';
                await fetchTodos();
            } catch (e) {
                alert('Failed to create todo');
            } finally {
                creating.value = false;
            }
        };

        const toggleTodo = async (todo) => {
            try {
                const res = await fetch(`/todos/${todo.id}/toggle`, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' },
                });
                if (!res.ok) throw new Error('Toggle failed');
                await fetchTodos();
            } catch (e) {
                alert('Failed to toggle');
            }
        };

        const deleteTodo = async (todo) => {
            if (!confirm('Delete this todo?')) return;
            try {
                const res = await fetch(`/todos/${todo.id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' },
                });
                if (!res.ok) throw new Error('Delete failed');
                todos.value = todos.value.filter((t) => t.id !== todo.id);
            } catch (e) {
                alert('Failed to delete');
            }
        };

        const promptEdit = (todo) => {
            edit.open = true;
            edit.id = todo.id;
            edit.title = todo.title;
            edit.description = todo.description || '';
            edit.is_completed = !!todo.is_completed;
        };

        const closeEdit = () => {
            edit.open = false;
            edit.id = null;
        };

        const submitEdit = async () => {
            if (!edit.id) return;
            updating.value = true;
            try {
                const res = await fetch(`/todos/${edit.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        title: edit.title,
                        description: edit.description,
                        is_completed: edit.is_completed,
                    }),
                });
                if (!res.ok) throw new Error('Update failed');
                closeEdit();
                await fetchTodos();
            } catch (e) {
                alert('Failed to update');
            } finally {
                updating.value = false;
            }
        };

        const logout = async () => {
            loggingOut.value = true;
            try {
                const res = await fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf(),
                        'Accept': 'application/json',
                    },
                });
                if (!res.ok) throw new Error('Logout failed');
                window.location.href = '/login';
            } catch (e) {
                alert('Failed to logout');
            } finally {
                loggingOut.value = false;
            }
        };

        fetchTodos();

        return { todos, form, edit, loading, creating, updating, loggingOut, fetchTodos, createTodo, toggleTodo, deleteTodo, promptEdit, closeEdit, submitEdit, logout };
    },
});

app.mount('#app');
</script>
</body>
</html>
