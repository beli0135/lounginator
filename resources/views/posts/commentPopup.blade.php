<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <div
            class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                viewBox="0 0 18 18">
                <path
                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                </path>
            </svg>
            <span class="text-sm">(Esc)</span>
        </div>

        <div class="modal-content py-4 text-left px-6">
            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">{{ __('lang.createcomment') }}</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="modal-body">
                
                <form method="POST" action="{{ route('createArticleComment') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}

                    <div class="form-group row">
                        <div class="col-md-6">
                            <textarea name="Tweet_body" id="Tweet_body" cols="45" rows="5" maxlength="250" autofocus placeholder="Comment minimum 3 letters..."></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col-3 pt-2">
                        <div class="w-10 h-10">
                            <label class="cursor-pointer" title="{{ __('lang.uploadimage') }}" >
                                <img src="{{ asset('/images/uploadphoto.png') }}" alt=""
                                    width="24" height="24">
                                <input type="file" name="cvrimg" class="hidden">
                            </label>

                        </div>
                        <div class="w-full">
                            @if (env('CUSTOM_NSFW_EXISTS') == true)
                                <label for="isNSFW" class="inline-flex items-center">
                                    <input id="isNSFW" name="isNSFW" type="checkbox" class="ml-4 rounded border-gray-300 text-indigo-600 
                                    shadow-sm focus:border-indigo-300 
                                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-red-600 font-extrabold">{{ __('lang.NSFWcontent') }}</span>
                                </label>
                            @endif
                        </div>
                        <div class="">
                            <button type="submit"
                                class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">{{ __('lang.post') }}</button>
                        </div>
                        <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    var openmodal = document.querySelectorAll('.modal-open')
    for (var i = 0; i < openmodal.length; i++) {
        openmodal[i].addEventListener('click', function (event) {
            event.preventDefault()
            toggleModal()
        })
    }

    const overlay = document.querySelector('.modal-overlay')
    overlay.addEventListener('click', toggleModal)

    var closemodal = document.querySelectorAll('.modal-close')
    for (var i = 0; i < closemodal.length; i++) {
        closemodal[i].addEventListener('click', toggleModal)
    }

    document.onkeydown = function (evt) {
        evt = evt || window.event
        var isEscape = false
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc")
        } else {
            isEscape = (evt.keyCode === 27)
        }
        if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal()
        }
    };

    function toggleModal() {
        const body = document.querySelector('body')
        const modal = document.querySelector('.modal')
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
    }

</script>
