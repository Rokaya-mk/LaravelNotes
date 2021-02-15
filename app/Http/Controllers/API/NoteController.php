<?php

namespace App\Http\Controllers\API;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Note as NoteResource;
use Illuminate\Support\Facades\Validator;

class NoteController extends BaseController

{
    //عرض ملاحظات المستخدم المسجل دخوله
    public function index()
    {
        $notes = Note::where('user_id' ,Auth::id())->get();
    return $this->sendResponse(NoteResource::collection($notes), '!تم إرسال جميع المنتجات' );
    }

     //اضافة ملاحظة جديدة
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required|string',
            'content'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('تحقق من صحة الخطأ',$validator->errors() );
        }

        $user = Auth::user();
        $input['user_id'] = $user->id;
        $post = Note::create($input);
        return $this->sendResponse($post, '!تمت إضافة المشاركة بنجاح' );

    }

    //اظهار معلومات ملاحظة واحدة معينة
    public function show($id)
    {
        $note = Note::find($id);
        if (is_null($note)) {
            return $this->sendError('!الملاحظة غير موجودة' );
        }
        return $this->sendResponse(new  NoteResource($note), '!تم العثور على الملاحظة بنجاح' );
    }

     // تعديل على ملاحظة معينة
    public function update(Request $request,Note $note)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required',
            'content'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('تحقق من صحة الخطأ' , $validator->errors());
        }

        if ( $note->user_id != Auth::id()) {
            return $this->sendError(' ليس لديك حقوق للتحديث' , $validator->errors());
        }
        $note->title = $input['title'];
        $note->content = $input['content'];
        $note->save();

        return $this->sendResponse(new NoteResource($note), '!تم تحديث الملاحظة بنجاح' );
    }

    //الحذف من قاعدة البيانات
    public function destroy(Note $note)
    {
        $errorMessage = [] ;
        if ($note->user_id != Auth::id()) {
            return $this->sendError('ليس لديك حقوق الحذف' , $errorMessage);
        } else {
            $note->forceDelete();
            return $this->sendResponse(new NoteResource($note), '!تم حذف الملاحظة بنجاح');

        }
    }
    //الحذف من واجهة المستخدم فقط
    public function softDelete($id)
    {
        $errorMessage = [] ;
        //$note = Note::destroy($id);
        $note = Note::find($id);
        if ($note->user_id != Auth::id()) {
            return $this->sendError('ليس لديك حقوق الحذف' , $errorMessage);
        } else {
            $note->delete();
            return $this->sendResponse(new NoteResource($note), '!تم حذف الملاحظة بنجاح');
        }
    }
    // استرجاع الملاحظة المحذوفة من واجهة المستخدم
    public function restore($id)

    {   $errorMessage = [] ;
        $note = Note::onlyTrashed()->where('id' , $id)->first();
            if (!is_null($note)) {
                $note->restore();
                return $this->sendResponse(new NoteResource($note), '!تم إسترجاعه');
            }else
            return $this->sendError('تحقق من صحة الخطأ' , $errorMessage);
        }

        //جذف الملاحظة الموجودة في سلة المهملات
        public function deleteSoftDeleted($id)

    {   $errorMessage = [] ;
        $note = Note::onlyTrashed()->where('id',$id)->first();
        if (is_null($note)){
            return $this->sendError('تحقق من صحة الخطأ' , $errorMessage);
        }
        if ($note->user_id != Auth::id()) {
            return $this->sendError('ليس لديك حقوق الحذف' , $errorMessage);
        } else {
            $note->forceDelete();
            return $this->sendResponse(new NoteResource($note), '!تم حذف الملاحظة بنجاح');
        }
    }

}
