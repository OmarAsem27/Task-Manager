<x-layout>

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-700">{{ __("Let's Do Some Work") }}</h1>
        <button data-modal-target="add-new-task" data-modal-toggle="add-new-task"
            class="p-3 bg-blue-600 text-white rounded-full shadow hover:bg-blue-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6">
                <title>New Task</title>
                <path
                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
            </svg>
        </button>
    </div>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Task List -->
    <div>
        @if ($tasks)
            @foreach ($tasks as $task)
                <div class="bg-gray-100 rounded-lg shadow p-6 mb-4 ">
                    <div class="flex justify-between items-start">
                        <div>
                            <a href="{{ route('tasks.show', $task) }}"
                                class="text-xl font-semibold hover:text-blue-700">{{ $task->body }}</a>
                            <p class="text-sm text-gray-500">
                                Status: <span class="font-medium">{{ $task->status }}</span>
                            </p>
                            <p class="text-sm text-gray-500">
                                Categories:
                                @foreach ($task->categories as $category)
                                    <span
                                        class="text-gray-700">{{ $category->name }}{{ !$loop->last ? ',' : '' }}</span>
                                @endforeach
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <!-- Delete Button -->
                            <button data-modal-target="{{ 'popup-modal' . $task->id }}"
                                data-modal-toggle="{{ 'popup-modal' . $task->id }}"
                                class="text-red-600 bg-red-100 px-3 py-1.5 rounded-lg hover:bg-red-200 focus:outline-none">
                                Delete
                            </button>
                            <!-- Edit Button -->
                            <button data-modal-target="{{ 'default-modal' . $task->id }}"
                                data-modal-toggle="{{ 'default-modal' . $task->id }}"
                                class="text-green-600 bg-green-100 px-3 py-1.5 rounded-lg hover:bg-green-200 focus:outline-none">
                                Edit
                            </button>
                            <!-- Change Status -->
                            <form method="POST" action="{{ route('status', $task->id) }}">
                                @csrf
                                @method('put')
                                <button type="submit"
                                    class="text-blue-600 bg-blue-100 px-3 py-1.5 rounded-lg hover:bg-blue-200 focus:outline-none">
                                    Change Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- delete confirmation modal --}}
                <div id="{{ 'popup-modal' . $task->id }}" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="{{ 'popup-modal' . $task->id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 ">Are you
                                    sure
                                    you want to
                                    delete this task?</h3>
                                <div class="flex justify-center">
                                    <form method="post" action="{{ route('tasks.destroy', $task->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button data-modal-hide="{{ 'popup-modal' . $task->id }}" type="submit"
                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center ">
                                            Yes, I'm sure
                                        </button>
                                    </form>
                                    <button data-modal-hide="{{ 'popup-modal' . $task->id }}" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 ">No,
                                        cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                {{-- edit modal --}}
                <!-- Main modal -->
                <div id="{{ 'default-modal' . $task->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Edit Task
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="{{ 'default-modal' . $task->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <form method="post" action="{{ route('tasks.update', $task->id) }}">
                                    @csrf
                                    @method('put')
                                    <div class="mb-5">
                                        <label for="task"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                            task</label>
                                        <input type="text" id="task"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="task..." name="body" required
                                            value="{{ $task->body }}" />
                                    </div>
                                    <div class="mb-5">
                                        <label for="category"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                        <input type="text" id="category"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="category..." name="category" required />
                                    </div>
                                    <!-- Modal footer -->
                                    <div
                                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                                        <button data-modal-hide="{{ 'default-modal' . $task->id }}" type="submit"
                                            class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center ">
                                            Confirm
                                        </button>
                                        <button data-modal-hide="{{ 'default-modal' . $task->id }}" type="button"
                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- create new task modal --}}
    <div id="add-new-task" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Task
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-new-task">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="mb-5">
                            <label for="task"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                task</label>
                            <input type="text" id="task"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="task..." name="body" required />
                        </div>
                        <div class="mb-5">
                            <label for="category"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categories
                                separated by a
                                comma</label>
                            <input type="text" id="category"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="category..." name="category" required />
                        </div>
                        <div class="mb-5">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                                an
                                option</label>
                            <select id="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="status" required>
                                <option value="">Status</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div
                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
