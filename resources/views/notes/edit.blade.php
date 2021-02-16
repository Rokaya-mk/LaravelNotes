@extends('layouts.app')


@section('content')
<div class="container ayat_ar_txt text-right" dir="rtl">
    <div class="row">
      <div class="col">
        <div class="jumbotron">
            <h1 class="display-4" style="padding-right: 40%; margin-block: 23px; font-weight:bold;">تعديل ملاحظة</h1>
            <a class="btn btn-success" href="{{route('notes')}}"> جميع الملاحظات</a>
           </div>
      </div>

    </div>
    <div class="row">

        @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $item)
                <li>
                    {{$item}}
                </li>
            @endforeach
        </ul>
        @endif


      <div class="col">
      <form action="{{route('note.update',$note->id)}}" method="Post">
        @csrf
        @method('PUT')
            <div class="form-group">
              <label for="exampleFormControlInput1">العنوان  </label>
            <input type="text" name="title" value="{{$note->title}}"  class="form-control" style="border: 2px solid #7c7b7b;"  >
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">المحتوى  </label>
              <textarea class="form-control"   name="content"   rows="3" style="border: 2px solid #7c7b7b;padding-bottom:20px;"> {{$note->content}} </textarea>
            </div>
            <div class="form-group" style="text-align: left">

                <button class="btn btn-danger" type="submit">تعديل </button>
            </div>

          </form>
      </div>
    </div>
  </div>
@endsection
