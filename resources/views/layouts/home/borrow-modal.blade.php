<div class="modal fade" id="borrow-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i>{{ Str::title($book->title) }}</i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="borrowForm" action="{{ route('library.borrow', $book) }}" method="POST">
                    @csrf

                    <div class="form-group text-left">
                        <label for="input-title">{{ trans('books.title') }}</label>
                        <input type="text" class="form-control-plaintext" id="input-title" value="{{ Str::title($book->title) }}">
                    </div>

                    <div class="form-group text-left">
                        <label for="input-from">{{ trans('library.borrow.from') }}</label>
                        <input type="date" class="form-control" id="input-from" name="from" required autofocus>
                    </div>

                    <div class="form-group text-left">
                        <label for="input-to">{{ trans('library.borrow.to') }}</label>
                        <input type="date" class="form-control" id="input-to" name="to" required>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ trans('general.cancel') }}
                </button>
                <button type="button" class="btn btn-primary" onclick="$('#borrowForm').submit()">
                    {{ trans('library.submit') }}
                </button>
            </div>
        </div>
    </div>
</div>
