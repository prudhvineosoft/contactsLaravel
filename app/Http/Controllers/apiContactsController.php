<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class apiContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allContacts = Contacts::all();
        return response(['data' => $allContacts, 'err' => 0, 'msg' => 'Success Contacts data'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|min:10|max:10|unique:contacts',
            'company' => 'required',
            'type' => 'required',
            'title' => 'required|unique:contacts',
            'image_path' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'validation error', 'err' => 1], 200);
        } else {
            $contact = new Contacts();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->mobile = $request->mobile;
            $contact->company = $request->company;
            $contact->type = $request->type;
            $contact->title = $request->title;
            $contact->image_path = $request->image_path;
            if ($contact->save()) {
                return response(['data' => $contact, 'msg' => 'Contact Created Successfully', 'err' => 0], 200);
            } else {
                return response(['msg' => 'Contact not added', 'err' => 1, 'error' => 'Something Went Wrong Contact not added'], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactById = Contacts::where('id', $id)->first();
        return response(['data' => $contactById, 'err' => 0, 'msg' => 'success'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contactById = Contacts::where('id', $id)->first();
        return response(['data' => $contactById, 'err' => 0, 'msg' => 'success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|min:10|max:10|unique:contacts,mobile,' . $id,
            'company' => 'required',
            'type' => 'required',
            'title' => 'required|unique:contacts,title,' . $id,
            'image_path' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'validation error', 'err' => 1], 200);
        } else {
            $updateContact = Contacts::find($id);
            $updateContact->name = $request->name;
            $updateContact->email = $request->email;
            $updateContact->mobile = $request->mobile;
            $updateContact->company = $request->company;
            $updateContact->type = $request->type;
            $updateContact->title = $request->title;
            $updateContact->image_path = $request->image_path;
            if ($updateContact->save()) {
                return response(['data' => $updateContact, 'err' => 0, 'msg' => 'success'], 200);
            } else {
                return response(['data' => $updateContact, 'err' => 1, 'msg' => 'Something Went Wrong'], 200);
            }
            // $updateContact = Contacts::where('id', $id)->update([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'mobile' => $request->mobile,
            //     'company' => $request->company,
            //     'type' => $request->type,
            //     'title' => $request->title,
            //     'image_path' => $request->image_path,
            // ]);
            // if ($updateContact) {
            //     return response(['data' => $updateContact, 'err' => 0, 'msg' => 'success'], 200);
            // } else {
            //     return response(['data' => $updateContact, 'err' => 1, 'msg' => 'Something Went Wrong'], 200);
            // }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteContact = Contacts::where('id', $id)->first();
        if ($deleteContact->delete()) {
            return response(['data' => $deleteContact, 'err' => 0, 'msg' => "deleted successfully"], 200);
        } else {
            return response(['data' => $deleteContact, 'err' => 1, 'msg' => "error"], 200);
        }
    }
}
