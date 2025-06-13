<!DOCTYPE html>
<html>

<head>
    <title>Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 40px;
            background-color: #f7f8fa;
        }

        h1 {
            color: #333;
        }

        select,
        input[type="text"],
        button {
            padding: 8px;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 200px;
        }

        .task-item {
            padding: 12px 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 8px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            cursor: move;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-list {
            max-width: 500px;
            margin-top: 20px;
        }

        form.inline {
            display: inline;
        }

        button {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
        }

        .drag-icon {
            margin-right: 10px;
            color: #888;
        }

        #message {
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Task Manager</h1>

    {{-- Project Dropdown --}}
    <form method="GET" action="/">
        <select name="project_id" onchange="this.form.submit()">
            @foreach ($projects as $project)
            <option value="{{ $project->id }}" {{ ($projectId == $project->id) ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
            @endforeach
        </select>
    </form>

    {{-- Add New Task --}}
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="hidden" name="project_id" value="{{ $projectId }}">
        <input type="text" name="name" placeholder="New Task" required>
        <button type="submit">Add</button>
    </form>

    {{-- Task List --}}
    <div id="task-list" class="task-list">
        @foreach ($tasks as $task)
        <div class="task-item" data-id="{{ $task->id }}">
            <span class="drag-icon">☰</span>
            <span>{{ $task->name }}</span>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" title="Delete">🗑</button>
            </form>
        </div>
        @endforeach
    </div>

    <div id="message"></div>

    {{-- SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        const taskList = document.getElementById('task-list');

        new Sortable(taskList, {
            onEnd: function() {
                const order = [];
                document.querySelectorAll('.task-item').forEach((el, index) => {
                    order.push({
                        id: el.dataset.id,
                        priority: index + 1
                    });
                });

                fetch(@json(route('tasks.reorder')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        order
                    })
                }).then(() => {
                    const msg = document.getElementById('message');
                    msg.innerText = '✔️ Task order updated!';
                    setTimeout(() => {
                        msg.innerText = '';
                    }, 2000);
                });
            }
        });
    </script>
</body>

</html>