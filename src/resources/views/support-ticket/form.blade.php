@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ $backUrl }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('Save') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('Information') }}">
                    {{ Field::text(__('Subject'), 'subject', ['value' => $model->subject, 'required' => true]) }}

					{{ Field::textarea(__('Content'), 'content', ['value' => $model->content, 'required' => true, 'rows' => 5]) }}
                </x-card>
            </div>

            <div class="col-md-3">
                <x-card title="{{ __('Settings') }}">
                    @php
                        $statusOptions = [
                            'open' => __('Open'),
                            'answered' => __('Answered'),
                            'closed' => __('Closed')
                        ];
                    @endphp
					{{ Field::select(__('Status'), 'status', ['value' => $model->status ?? 'open', 'required' => true])
                        ->dropDownList($statusOptions)
                    }}

                    @php
                        $categories = \Juzaweb\Modules\SupportTicket\Models\SupportTicketCategory::query()
                            ->get();
                        $categoryOptions = ['' => __('-- Select Category --')];
                        foreach($categories as $category) {
                            $categoryOptions[$category->id] = $category->name;
                        }
                    @endphp
                    {{ Field::select(__('Category'), 'category_id', ['value' => $model->category_id])
                        ->dropDownList($categoryOptions)
                    }}
                </x-card>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        $(function () {
            //
        });
    </script>
@endsection
