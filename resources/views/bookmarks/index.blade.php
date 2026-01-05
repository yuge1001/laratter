<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ブックマーク一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($bookmarks as $tweet)
                        <div class="mb-4 border-b border-gray-300 pb-2">
                            <p><strong>{{ $tweet->user->name }}</strong></p>
                            <p>{{ $tweet->tweet }}</p>
                            <small>投稿日: {{ $tweet->created_at->format('Y-m-d H:i') }}</small><br>
                            <small>ブックマークした日: {{ $tweet->pivot->created_at->format('Y-m-d H:i') }}</small>
                            <small>コメント:{{$tweet->created_at->format('Y-m-d H:i') }}</small>
                            <form action="{{ route('bookmarks.destroy', $tweet) }}" method="POST" class="mt-2">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="text-red-500 hover:underline">
                                    ブックマーク解除
                                  </button>
                            </form>
                        </div>
                    @empty
                        <p>まだブックマークがありません。</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




