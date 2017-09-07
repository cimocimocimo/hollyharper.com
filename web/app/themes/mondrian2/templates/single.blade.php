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

  @endwhile
@endsection
