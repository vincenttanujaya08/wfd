{{-- resources/views/admin/reports/show.blade.php --}}
@extends('admin.layouts.template')
@section('title','Report #'.$report->id)

@section('head')
<style>
  /* slider container */
.image-container {
  max-width: 800px;
  height: 450px;
  position: relative;
  margin: auto;
  overflow: hidden;
  background: #000;
}

/* each slide fills the container */
.slide {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  display: none;
}

/* make the image always scale to fit */
.slide img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  background: #000;
}


  /* slide number badge */
  .slideNumber {
    background-color: rgba(85,116,197,.7);
    color: white;
    border-radius: 25px;
    padding: 5px 10px;
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 18px;
    font-weight: bold;
  }

  /* prev/next controls */
  .previous, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    padding: 16px;
    margin-top: -22px;
    color: white;
    background: rgba(0,0,0,0.4);
    border-radius: 50%;
    user-select: none;
  }
  .previous { left: 16px; }
  .next     { right: 16px; }
  .previous .fa, .next .fa { font-size: 24px; }

  /* footer dots */
  .footerdot {
    cursor: pointer;
    height: 15px; width: 15px;
    margin: 0 4px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.3s;
  }
  .active, .footerdot:hover {
    background-color: #717171;
  }

  /* detail cards */

  .info-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: .5rem;
  }
  /* beneath your existing .actions button styles */

.actions {
  display: flex;
  justify-content: center;  /* center the buttons horizontally */
  gap: 1rem;                /* space them out evenly */
  margin-top: 1rem;         /* give a little breathing room above */
}

  .actions button {
    margin-right: 1rem;
    padding: .75rem 1.25rem;
    border: none;
    border-radius: .375rem;
    color: #fff;
    cursor: pointer;
  }

  .detail-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  align-items: stretch; /* <-- ensures equal height */
}

/* turn the right card into a vertical flex container */
.info-card.right-panel {
  display: flex;
  flex-direction: column;
}

/* let the description area grow to push the form down */
.description-content {
  flex: 1;
}

/* center the buttons at the bottom */
.actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1rem;
}
  .btn-cancel  { background: #6b7280; }
  .btn-warning { background: #f59e0b; }
  .btn-ban     { background: #ef4444; }

  
</style>
@endsection

@section('content')


  {{-- Image Slider --}}
  <div class="image-container">
    @foreach($report->images as $i => $img)
      <div class="slide">
        <div class="slideNumber">{{ $i+1 }}</div>
        <img src="{{ asset('storage/'.$img->image_path) }}" alt="Evidence {{ $i+1 }}">
      </div>
    @endforeach

    <a class="previous" onclick="moveSlides(-1)"><i class="fa fa-chevron-circle-left"></i></a>
    <a class="next"     onclick="moveSlides(1)"><i class="fa fa-chevron-circle-right"></i></a>
  </div>

  <div style="text-align:center; margin-top:8px;">
    @foreach($report->images as $i => $img)
      <span class="footerdot" onclick="activeSlide({{ $i+1 }})"></span>
    @endforeach
  </div>

  {{-- Details & Actions --}}
<div class="detail-grid">
  {{-- Left panel --}}
  <div class="info-card">
    <h2 class="font-semibold mb-2">Reporter</h2>
    <p>{{ $report->reporter->name }}<br>{{ $report->reporter->email }}</p>
    <hr class="my-4">
    <h2 class="font-semibold mb-2">Reported User</h2>
    <p>{{ $report->reportedUser->name }}<br>{{ $report->reportedUser->email }}</p>
  </div>

  {{-- Right panel (now a single flex‐column card) --}}
  <div class="info-card right-panel">
    <div class="description-content">
      <h2 class="font-semibold mb-2">Description</h2>
      <p>{{ $report->description }}</p>
    </div>

</div>
</div>
<div>
    <form action="{{ route('admin.reports.handle',$report) }}"
          method="POST"
          class="actions">
      @csrf
      <button name="action" value="cancel"  class="btn-cancel">Delete Report</button>
      <button name="action" value="warning" class="btn-warning">Warning</button>
      <button name="action" value="ban"     class="btn-ban">Ban User</button>
    </form>
  </div>
  {{-- Report Status --}}
@endsection

@section('scripts')
<script>
  let slideIndex = 1;
  showSlide(slideIndex);

  function moveSlides(n) {
    showSlide(slideIndex += n);
  }
  function activeSlide(n) {
    showSlide(slideIndex = n);
  }

  function showSlide(n) {
    const slides = document.getElementsByClassName("slide");
    const dots   = document.getElementsByClassName("footerdot");
    if (n > slides.length) { slideIndex = 1; }
    if (n < 1)            { slideIndex = slides.length; }
    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (let i = 0; i < dots.length; i++) {
      dots[i].classList.remove("active");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].classList.add("active");
  }
</script>
@endsection
