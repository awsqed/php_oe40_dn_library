<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Book;
use Tests\ModelTestCase;
use App\Models\BorrowRequest;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class BorrowRequestTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new BorrowRequest();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('borrow_requests', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertTrue($this->model->getIncrementing());

        $this->assertSame([
            'created_at',
            'updated_at',
        ], $this->model->getDates());
    }

    public function test_borrow_request_belongs_to_an_user()
    {
        $this->assertBelongsTo('user', User::class, 'user_id');
    }

    public function test_borrow_request_belongs_to_a_book()
    {
        $this->assertBelongsTo('book', Book::class, 'book_id');
    }

    public function test_borrow_request_returns_rejected_status_text_when_it_is_rejected()
    {
        $this->model->status = config('app.borrow-request.status-code.rejected');

        $this->assertSame(trans('library.borrow.rejected'), $this->model->status_text);
    }

    public function test_borrow_request_returns_borrowing_status_text_when_it_is_accepted()
    {
        $this->model->status = config('app.borrow-request.status-code.accepted');
        $this->travel(1)->days();
        $this->model->to = now()->toDateString();
        $this->travelBack();

        $this->assertSame(trans('library.borrow.borrowing'), $this->model->status_text);
    }

    public function test_borrow_request_returns_overdue_status_text_when_it_is_overdue()
    {
        $this->model->status = config('app.borrow-request.status-code.accepted');
        $this->model->to = now()->toDateString();
        $this->travel(1)->days();

        $this->assertSame(trans('library.borrow.overdue'), $this->model->status_text);
    }

    public function test_borrow_request_returns_returned_status_text_when_it_is_returned()
    {
        $this->model->status = config('app.borrow-request.status-code.returned');

        $this->assertSame(trans('library.borrow.returned'), $this->model->status_text);
    }

    public function test_borrow_request_returns_returned_late_status_text_when_it_is_returned_late()
    {
        $this->model->status = config('app.borrow-request.status-code.returned-late');

        $this->assertSame(trans('library.borrow.returned-late'), $this->model->status_text);
    }

    public function test_borrow_request_returns_processing_status_text_with_other_status_codes()
    {
        $this->assertSame(trans('library.borrow.processing'), $this->model->status_text);
    }

    public function test_borrow_request_returns_overdue_note_when_it_is_overdue()
    {
        $this->model->status = config('app.borrow-request.status-code.accepted');
        $this->model->to = now()->toDateString();
        $this->travel(1)->days();
        $to = new Carbon($this->model->to);

        $this->assertSame(
            trans('library.borrow.overdue') .' ('. trans_choice('library.borrow.days-late', $to->diffInDays(now())) .')',
            $this->model->note_text
        );
    }

    public function test_borrow_request_returns_returned_late_note_when_it_is_returned_late()
    {
        $this->model->status = config('app.borrow-request.status-code.returned-late');
        $note = 'foobar';
        $this->model->note = $note;

        $to = new Carbon($this->model->to);
        $returnedAt = new Carbon($this->model->returned_at);

        $this->assertSame(
            $note .' ('. trans_choice('library.borrow.days-late', $to->diffInDays($returnedAt)) .')',
            $this->model->note_text
        );
    }

    public function test_borrow_request_returns_normal_note_with_other_cases()
    {
        $note = 'foobar';
        $this->model->note = $note;

        $this->assertSame($note, $this->model->note_text);
    }

    public function test_model_has_default_sort_scope()
    {
        $this->assertInstanceOf(Builder::class, BorrowRequest::defaultSort());
    }

}
