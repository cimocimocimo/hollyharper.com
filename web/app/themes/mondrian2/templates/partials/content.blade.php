<article @php(post_class())>
  @if (has_post_thumbnail())
  @php(the_post_thumbnail())
  @endif

  <div class="article-body">
    <div class="article-content">
  <header>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
    @include('partials/entry-meta')
  </header>
  <div class="entry-summary">
    @php(the_excerpt())
  </div>
    </div>
  </div>
</article>
