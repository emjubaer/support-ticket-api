<form method="POST" action="{{ route($routeName, $ticket->id) }}">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="{{ $status }}">
    <button type="submit"
        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b">
        {{ $buttonText }}
    </button>
</form>
