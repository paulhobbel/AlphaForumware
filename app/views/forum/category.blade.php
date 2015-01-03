@extends('layouts.master')

@section('head')
	@parent
	<title>Forum | {{ $category->title }}</title>
	<style type="text/css">
	#category_edit .modal-content{

		border: 0;
		border-radius: 0;
	}
	#category_edit .modal-body {
		padding: 15px 15px 0;
	}
	#category_edit h3 {
		margin: 0;
		text-align: center;
	}
	#category_edit .category-edit-confirm-btn {
		float: right;
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #fff;
		background-color: #337ab7;
		width: 50%;
	}
	#category_edit .category-edit-confirm-btn:hover {
		background-color:#286090;
	}
	#category_edit .category-edit-cancel-btn {
		text-decoration: none;
		display: inline-block;
		padding: 6px 12px;
		text-align: center;
		cursor: pointer;
		border: 0;
		color: #333;
		background-color: #fff;
		width: 50%;
	}
	#category_edit .category-edit-cancel-btn:hover {
		background-color:#e6e6e6;
	}

	</style>
@stop

@section('content')

<ol class="breadcrumb">
	<li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
	<li class="active">{{ $category->title }}</li>
</ol>

<div class="panel panel-primary">
	<div class="panel-heading">
		@if(Auth::check() && Auth::user()->isAdmin())
		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $category->title }}</h3>
			<div class="dropdown pull-right">
				<button id="options-menu" type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="options-menu">
					<li><a href="{{ URL::route('forum-get-new-thread', $category->id) }}">New Thread</a></li>
					<li><a href="#" data-function="edit.category" data-id="{{ $category->id }}">Edit Category</a></li>
					<li><a href="#" data-toggle="modal" data-target="#delete_modal" data-backdrop="false" data-function="delete.btn" data-id="{{ $category->id }}" data-what="category">Delete Category</a></li>
				</ul>
			</div>
		</div>
		@elseif(Auth::check())
		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $category->title }}</h3>
			<a href="{{ URL::route('forum-get-new-thread', $category->id) }}" class="label label-success pull-right">New Tread</a>
		</div>
		@else
			<h3 class="panel-title">{{ $category->title }}</h3>
		@endif
	</div>
	<div class="list-group">
	@foreach($threads as $thread)
		<a href="{{ URL::route('forum-thread', $thread->id) }}" class="list-group-item group_delete">{{ $thread->title }}</a>
	@endforeach
	</div>
</div>

@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<h3>Are you shure?</h3>
			</div>
			<button class="delete-cancel-btn" type="button" data-dismiss="modal">Cancel</button>
			<a class="delete-confirm-btn">Confirm</a>
		</div>
	</div>
</div>

<div class="modal fade" id="category_edit" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				
				{{ Form::open() }}

				    {{ Form::openGroup('category_name_edit', 'Category Name:') }}
				        {{ Form::text('category_name_edit') }}
				    {{ Form::closeGroup() }}

				{{ Form::close() }}

			</div>
			<button type="button" class="category-edit-cancel-btn" data-dismiss="modal">Cancel</button>
			<button type="button" class="category-edit-confirm-btn">Save Category</button>
		</div>
	</div>
</div>
@endif

@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>

	@if(Session::has('category-edit') && Session::has('category-id'))
		<script type="text/javascript">
			$('#category_edit form').prop('action', "/forum/category/{{ Session::get('category-id') }}/edit");
			$('{{ Session::get('category-edit') }}').modal({'backdrop': false}, 'show');
		</script>
	@endif
@stop