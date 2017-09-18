@extends('layouts.base')

@section('content')
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  @if($old_single_post_data)
    {!! var_dump($old_single_post_data) !!}
  @endif

  @while(have_posts()) @php(the_post())
    @include('partials/content-single-'.get_post_type())

    @if( Single::old_single_post_in_loop_data() )
      {!! var_dump(Single::old_single_post_in_loop_data()) !!}
    @endif

    @if( Single::check_if_blog() )
      <h1>This is a blog</h1>
    @else
      <h1>This is a listing</h1>
      {!! var_dump(Single::get_post_attachments()) !!}
      {!! $first = true; !!}
      @foreach( Single::get_post_attachments() as $img_data)

        <h2>image</h2>
        {!! var_dump($img_data) !!}
        <div class="slide{{$first ? ' first' : '' }}">
          <img src="{{$img_data->slide_img->url}}" width="{{$img_data->slide_img->width }}" height="{{$img_data->slide_img->height }}" />
        <?php if ($img_data->post_excerpt) : ?>
          <div class="slide-meta-box">
            <p>{{$img_data->post_excerpt}}</p>
          </div>
        <?php endif; ?>
        </div>
              
      @endforeach
    @endif

  @endwhile
@endsection
