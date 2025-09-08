@extends('layout.dashboard.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Manage Categories</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <button id="addCategoryBtn" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Category</button>

    <table class="w-full table-auto border border-gray-300 rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td class="border px-4 py-2">{{ $category->id }}</td>
                <td class="border px-4 py-2">{{ $category->name }}</td>
                <td class="border px-4 py-2">{{ $category->description }}</td>
                <td class="border px-4 py-2 space-x-2">
                    <button class="editCategoryBtn px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500" 
                        data-id="{{ $category->id }}" 
                        data-name="{{ $category->name }}" 
                        data-desc="{{ $category->description }}">
                        Edit
                    </button>
                    <form action="{{ route('manage-category.destroy', $category->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>

<!-- Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Category</h2>
        <form id="categoryForm" method="POST" action="{{ route('manage-category.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" id="categoryName" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Description</label>
                <textarea name="description" id="categoryDescription" class="w-full border px-3 py-2 rounded"></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" id="submitBtn">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('categoryModal');
    const addBtn = document.getElementById('addCategoryBtn');
    const closeModalBtn = document.getElementById('closeModal');
    const modalTitle = document.getElementById('modalTitle');
    const categoryForm = document.getElementById('categoryForm');
    const formMethod = document.getElementById('formMethod');
    const categoryName = document.getElementById('categoryName');
    const categoryDescription = document.getElementById('categoryDescription');

    // Show add modal
    addBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Add Category';
        categoryForm.action = "{{ route('manage-category.store') }}";
        formMethod.value = 'POST';
        categoryName.value = '';
        categoryDescription.value = '';
        modal.classList.remove('hidden');
    });

    // Close modal
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Edit buttons
    const editBtns = document.querySelectorAll('.editCategoryBtn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const desc = btn.dataset.desc;

            modalTitle.textContent = 'Edit Category';
            categoryForm.action = `/manage-category/${id}`;
            formMethod.value = 'PUT';
            categoryName.value = name;
            categoryDescription.value = desc;
            modal.classList.remove('hidden');
        });
    });
</script>
@endsection
