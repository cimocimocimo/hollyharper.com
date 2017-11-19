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
      {{--  {!! var_dump(Single::get_post_attachments()) !!}  --}}

      {!! $first = true !!}
      @foreach( Single::get_post_attachments()['images'] as $img_data)
        <div class="slide{{$first ? ' first' : '' }}">
          <img src="{{$img_data->slide_img->url}}" width="{{$img_data->slide_img->width }}" height="{{$img_data->slide_img->height }}" />
          {{--  I can't see how the post excerpt could have possibly been displaying before,
                and it definitely doesn't at the moment. But I've transferred it over for
                the time being just in case.  --}}
          @if ($img_data->post_excerpt)
            <div class="slide-meta-box">
              <p>{{$img_data->post_excerpt}}</p>
            </div>
          @endif
        </div>
        {!! $first = false !!}
      @endforeach

      @foreach( Single::get_post_attachments()['images'] as $index => $img_data )
        <div id="pager-img-{{$index}}">
          <img src="{{$img_data->pager_img->url}}" width="{{$img_data->pager_img->width}}" height="{{$img_data->pager_img->height}}" />
        </div>
      @endforeach

      @foreach( Single::old_single_post_in_loop_data()['listing'] as $key => $value )
        @if( $value && $key != 'price' && isset($value->label) )
          {{ $value->label }}
          {{ $value->data }}
        @endif
      @endforeach

      @if( isset(Single::get_post_attachments()['pdfs']) )
        @foreach( Single::get_post_attachments()['pdfs'] as $attached_pdfs)

          @if($attached_pdfs)
            {{--  I don't know how the PDF attachment types were differentiated before, 
                  so just going to assume floorplan is the only attachment --}}
            {!! var_dump($attached_pdfs) !!}
            <a href="{{ $attached_pdfs->guid }}">Floorplan</a>
          @endif

        @endforeach
      @endif

      @if(in_category('sold'))
        {{ $listing_title = 'SOLD - ' . get_the_title() }}
      @else
        {{ $listing_title = get_the_title() }}
      @endif

      @if( Single::old_single_post_in_loop_data() )
        @php
          $listing = Single::old_single_post_in_loop_data()['listing']
        @endphp
        {!! $listing->price->data !!}
      @endif

      {{ the_content() }}
      {!! var_dump(Single::show_interior_features()) !!}

    @endif {{-- end if else blog --}}

  @endwhile
@endsection
