@extends('layouts.app')


@section('content')
<div class="container ayat_ar_txt text-right" dir="rtl">
    <div class="row">
    <div class="row">
      <div class="col">

        <div class="card text-white bg-info mb-3"   >
            <div class="card-body">
              <h5 class="card-title">{{$note->title}}</h5><br>
              <p class="card-text"> {{$note->content}}</p><br><br><br>
            <p style="text-align: left">  تم الانشاء في :   {{$note->created_at->diffForhumans() }}</p>
            <p style="text-align: left">  تم التعديل في:    {{$note->updated_at->diffForhumans() }}</p><br>

            </div>
          </div>
          <div class="form-group" style="text-align: left">

            <a class="btn btn-success" style="text-align: left ;margin:0 0 20px" href="{{route('notes')}}"> جميع الملاحظات </a>
        </div>

      </div>
    </div>
  </div>


@endsection
