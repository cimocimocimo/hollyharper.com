@extends('layouts.base')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials/content-single-'.get_post_type())
    @if($old_single_post_data)
      {!! var_dump($old_single_post_data) !!}
    @endif
  @endwhile
@endsection
