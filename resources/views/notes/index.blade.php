@extends('layouts.app')

@section('content')
<div class="container ayat_ar_txt text-right" dir="rtl">
    <div class="row" >
      <div class="col">
        <div class="jumbotron " >
           <h1 class="display-4" style="padding-right: 40%; margin-block: 23px;font-weight:bold;"> جميع الملاحظات </h1>
        @if (auth()->user()->is_admin)
          <a class="btn btn-info" href="{{route('notes.create')}}"> انشئ ملاحظة &nbsp;<i class="fas fa-plus"></i></a>
          <a class="btn btn-danger" href="{{route('notes.trashed')}}"> المهملات <i class="fas fa-trash"></i></a>
        @endif
        </div>
      </div>
    </div>
    <div class="row">


        {{-- @if ($notes->count() > 0 ) --}}
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
                    @forelse ($notes as $item)
                    <tr style="border-top: 2px solid #7c7b7b;">
                      <th scope="row">{{$i++}}</th>
                      <td>{{$item->title}}</td>
                      <td>{{$item->created_at->diffForhumans() }}</td>
                      <td>

                          <a  class="text-success" href="{{route('notes.show',['id'=> $item->id]) }}"> <i class="fas  fa-2x fa-eye"></i> </a>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <a href="{{route('notes.edit',['id'=> $item->id])}}"> <i class="fas fa-2x fa-edit"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
                          <a  class="text-warning" href="{{route('notes.softDelete',['id'=> $item->id])}}"> <i class="fas fa-2x fa-archive"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                          <a class="text-danger" href="{{route('notes.destroy',['id'=> $item->id])}}"> <i class="fas  fa-2x fa-trash-alt"></i> </a>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="4">
                        <div class="col">
                          <div class="alert alert-danger" role="alert">
                            لا توجد ملاحظات
                            </div>
                        </div>

                      </td>
                    </tr>
                    @endforelse 

                </tbody>
              </table>
          </div>

        {{-- @endif --}}


    </div>
  </div>
@endsection
