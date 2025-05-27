<div>
    <div class="content">
         @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="alert alert-success"
        >
            {{ session('success') }}
        </div>
    @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->itemname }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->created_by }}</td>
                        <td>
                            <button wire:click="delete({{ $item->id }})" class="btn btn-danger btn-sm"
                                onclick="confirm('Delete this item?') || event.stopImmediatePropagation()">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $items->links() }}
    </div>
</div>
