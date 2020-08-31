@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ZingMp3') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group">
                    <form action="" method="get">
                        <div class="form-group">
                          <label for="url">URL</label>
                          <input type="text" class="form-control" id="url" name="link" placeholder="URL" value="{{$link}}">
                          <small class="form-text text-muted">Example: <a href="https://zingmp3.vn/bai-hat/Ex-s-Hate-Me-Part-2-AMEE-B-Ray/ZWBU7OO7.html" target="_blank" rel="noopener noreferrer">https://zingmp3.vn/bai-hat/Ex-s-Hate-Me-Part-2-AMEE-B-Ray/ZWBU7OO7.html</a></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                    @if($data != null)
                    <div class="container">
                        <div class="row">
                          <div class="col-6">
                            <div class="card" style="width: 18rem; height: 25rem;">
                                <img class="card-img-top" src="{{$data->data->album->thumbnail_medium}}" alt="Card image cap">
                                <div class="card-body">
                                  <h5 class="card-title">{{$data->data->name}}</h5>
                                  <p class="card-text">{{$data->data->artists_names}}</p>
                                </div>
                            </div>  
                          </div>
                          <div class="col-6">
                            <div class="card" style="width: 18rem; height: 25rem; overflow: scroll;">
                                <div class="card-body">
                                  <p class="card-text">{!!$lyric!!}</p>
                                </div>
                            </div>  
                          </div>
                          </div>
                        </div>
                      </div>
                      <video controls autoplay>
                        <source src="{{$download}}" type="audio/mpeg">
                    </video>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection