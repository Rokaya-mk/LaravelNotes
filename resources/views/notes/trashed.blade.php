@extends('layouts.app')

@section('content')
<div class="container ayat_ar_txt text-right" dir="rtl">
    <div class="row">
      <div class="col">
        <div class="jumbotron">
            <h1 class="display-4" style="padding-right: 40%; margin-block: 23px; font-weight:bold;">الملاحظات المهملة </h1>
        <a class="btn btn-success" href="{{route('notes')}}"> جميع الملاحظات</a>
           </div>
      </div>
    </div>
    <div class="row">
        @if ($notes->count() > 0 )
        <div class="col">
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">العنوان</th>
                    <th scope="col"> التاريخ</th>
                    <th scope="col">الاجراءات</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($notes as $item)
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$item->title}}</td>
                        <td>{{$item->created_at->diffForhumans() }}</td>
                        <td>
                            <a  class="text-success" href="{{route('note.restore',['id'=> $item->id])}}"> <i class="fas fa-2x fa-undo"></i> </a> &nbsp;&nbsp;
                        <a class="text-danger" href="{{route('note.deleteSoft',['id'=> $item->id])}}"> <i class="fas  fa-2x fa-trash-alt"></i> </a>
                        </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
          </div>
        @else
        <div class="col">
            <div class="alert alert-danger" role="alert" >
               المهملات فارغة
              </div>
        </div>
        @endif
    </div>
  </div>
@endsection
