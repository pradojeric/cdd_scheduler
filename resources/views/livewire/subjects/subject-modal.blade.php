<div>
    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
                Background overlay, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!--
                Modal panel, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-screen">
                <div class="bg-gray-200">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <span class="uppercase font-bold">{{ __('Updating Subjects') }}</span>
                    </div>
                    <div class="bg-white w-screen px-6 py-2 ">
                        <div class="flex space-x-2">
                            <x-input type="checkbox" id="delete_inactive" value=1 wire:model="deleteAll" />
                            <x-label for="delete_inactive" value="Delete all inactive curriculum" />
                        </div>
                    </div>
                </div>

                <div class="bg-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse items-center">
                    <button type="button" wire:click="updateSubjects"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        <div wire:loading wire:target="updateSubjects"><i class="fa fa-spinner fa-spin"></i></div>
                        Proceed
                    </button>
                    <button type="button" wire:click="$toggle('isModalOpen')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                    <span class=" text-yellow-700 text-xs pr-3">Warning! Some schedule may be removed after
                        updating. Proceed?</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
