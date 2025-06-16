@extends('admin.layouts.template')
@section('title','Report Details')
@section('content')
  <div class="report-detail">
    <div class="image-slider">
      @foreach($report->images as $img)
        <div class="slide"><img src="{{ asset('storage/'.$img->image_path) }}" alt="Evidence"></div>
      @endforeach
    </div>
    <div class="info-card">
      <h3>Description</h3>
      <p>{{ $report->description }}</p>
      <h3>Reported User</h3>
      <p>{{ $report->reportedUser->name }}</p>
    </div>
    <form action="{{ route('admin.reports.update',$report) }}" method="POST">
      @csrf @method('PUT')
      <button name="action" value="cancel" class="btn-cancel">Cancel Report</button>
      <button name="action" value="warning" class="btn-warning">Warning</button>
      <button name="action" value="ban" class="btn-ban">Ban User</button>
    </form>
  </div>
@endsection
