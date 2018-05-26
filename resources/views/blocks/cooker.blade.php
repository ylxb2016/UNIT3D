{{-- Add Recipe Block --}}
<div class="col-md-10 col-sm-10 col-md-offset-1">
    <div class="clearfix visible-sm-block"></div>
    <div class="panel panel-chat shoutbox">
        <div class="panel-heading">
            <h4>The Cooker (Upcoming Internal Uploads)
                @if(auth()->user()->group->is_internal || auth()->user()->group->is_modo)
                    <button class="btn btn-xs btn-default" style="float:right" data-toggle="modal"
                            data-target="#modal_add_recipe"><i class="fa fa-plus"></i>Add Recipe
                    </button>
                @endif
            </h4>
        </div>
        @if(count($recipes) == 0)
            <div class="text-center">
                <h4 class="text-bold text-danger">
                    <i class="fa fa-frown-o"></i> Nothing In The Cooker!
                </h4>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Recipe Name</th>
                        <th>Chef</th>
                        <th>Status</th>
                        <th>Notify</th>
                        @if(auth()->user()->group->is_internal || auth()->user()->group->is_modo)
                        <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recipes as $recipe)
                        <tr>
                            <td><span class="label label-success">{{ $recipe->category->name }}</span></td>
                            <td><span class="label label-info">{{ $recipe->type }}</span></td>
                            <td><a href="#">{{ $recipe->name }}</a></td>
                            <td>{{ $recipe->user->username }}</td>
                            <td>{{ $recipe->status }}</td>
                            {{--}}@if()--}}
                            <td>
                                <button class="btn btn-xs btn-info"><i class="fa fa-bell"></i> Notify Me!</button>
                            </td>
                            {{--}}@else
                                <td>
                                    <button class="btn btn-xs btn-danger"><i class="fa fa-bell-slash-o"></i> Unnotify
                                        Me!
                                    </button>
                                </td>
                            @endif--}}
                            @if(auth()->user()->group->is_internal || auth()->user()->group->is_modo)
                                <td>
                                    <a href="{{ route('updateRecipe', ['id' => $recipe->id]) }}"
                                       class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ route('destroyRecipe', ['id' => $recipe->id]) }}"
                                       class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</a>
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
<div class="modal fade" id="modal_add_recipe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add A New Recipe</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('storeRecipe') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="imdb">IMDB ID <b>(Required)</b></label>
                        <input type="number" name="imdb" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tmdb">TMDB ID <b>(Required)</b></label>
                        <input type="number" name="tmdb" class="form-control" required>
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
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="Sourcing">Sourcing</option>
                            <option value="Encoding">Encoding</option>
                            <option value="Remuxing">Remuxing</option>
                            <option value="Ripping">Ripping</option>
                            <option value="FTP'ing">FTP'ing</option>
                            <option value="Uploaded">Uploaded</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="upload-form-description" name="description" cols="30" rows="10"
                                  class="form-control"></textarea>
                    </div>
                        <input type="submit" value="{{ trans('common.add') }}" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
{{-- /END Add Recipe Modal --}}