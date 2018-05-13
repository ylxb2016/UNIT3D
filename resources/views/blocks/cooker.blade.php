{{-- Add Recipe Block --}}
<div class="col-md-10 col-sm-10 col-md-offset-1">
    <div class="clearfix visible-sm-block"></div>
    <div class="panel panel-chat shoutbox">
        <div class="panel-heading">
            <h4>The Cooker
                @if(auth()->user()->group->is_internal || auth()->user()->group->is_modo)
                    <button class="btn btn-xs btn-default" style="float:right" data-toggle="modal"
                            data-target="#modal_add_recipe"><i class="fa fa-plus"></i>Add Recipe
                    </button>
                @endif
            </h4>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Recipe Name</th>
                    <th>Expected</th>
                    <th>Chef</th>
                    <th>Status</th>
                    <th>Notify</th>
                </tr>
                </thead>
                <tbody>
                @if(count($recipes) == 0)
                    <div class="text-center"><h4 class="text-bold text-danger"><i
                                    class="fa fa-frown-o"></i> Nothing In The Cooker!</h4>
                    </div>
                @else
                    @foreach($recipes as $recipe)
                        <tr>
                            <td><span class="label label-success">{{ $recipe->category }}</span></td>
                            <td><span class="label label-info">{{ $recipe->type }}</span></td>
                            <td><a href="#">{{ $recipe->name }}</a></td>
                            <td>{{ $recipe->expected }}</td>
                            <td>{{ $recipe->chef->username }}</td>
                            <td>{{ $recipe->status }}</td>
                            @if()
                                <td>
                                    <button class="btn btn-xs btn-info"><i class="fa fa-bell"></i> Notify Me!</button>
                                </td>
                            @else
                                <td>
                                    <button class="btn btn-xs btn-danger"><i class="fa fa-bell-slash-o"></i> Unnotify
                                        Me!
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- /END Add Recipe Block --}}

{{-- Add Recipe Modal --}}
<div class="modal fade" id="modal_add_recipe" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <meta charset="utf-8">
            <title>Add New Recipe</title>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('common.close') }}"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title"
                    id="myModalLabel">Add New Recipe</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('postRecipe') }}">
                    <div class="form-group">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="name">IMDB ID <b>(Required)</b></label>
                        <input type="number" name="imdb" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" class="form-control">
                            @foreach($types as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <input class="btn btn-primary" type="submit" value="{{ trans('common.add') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-default" type="button"
                    data-dismiss="modal">{{ trans('common.close') }}</button>
        </div>
    </div>
</div>
{{-- /END Add Recipe Modal --}}