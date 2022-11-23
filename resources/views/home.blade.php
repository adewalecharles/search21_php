@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Awesome Tasks') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif

                     <div class="scroll-area-sm">
                        <perfect-scrollbar class="ps-show-limits">
                            <div style="position: static;" class="ps ps--active-y">
                            <div class="ps-content">
                                <ul class=" list-group list-group-flush">
                                    @forelse ($tasks as $task)
                                    <li class="list-group-item">
                                    <div class="todo-indicator bg-warning"></div>
                                    <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">

                                        </div>
                                        </div>
                                        <div class="widget-content-left">
                                        <div class="widget-heading">{{$task['title']}}
                                        </div>

                                        </div>
                                    <div class="widget-content-right">
                                        <button data-toggle="modal" data-target="#editModal{{$task['_id']}}" class="border-0 btn-transition btn btn-outline-success edit-btn" id="{{$task['_id']}}">
                                        <i class="fa fa-edit"></i></button>
                                        <form action="{{route('task.delete', $task['_id'])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                         <button class="border-0 btn-transition btn btn-outline-danger delete-btn" type="submit">
                                        <i class="fa fa-trash"></i>
                                        </button>
                                        </form>

                                    </div>
                                    </div>
                                    </div>
                                </li>
                                @include('modal.edit', ['task' => $task])
                                    @empty
                                    <div class="text-center">
                                        No Task Created yet!
                                    </div>
                                    @endforelse

                                </ul>
                            </div>

                            </div>
                        </perfect-scrollbar>
                        </div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Add Task</button></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.create');
@endsection
@push('js')
<script>
    $(".delete-btn").click(function(e){
        e.preventDefault();
        return confirm('Are you sure you want to delete this task')
    });
</script>
@endpush
