<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Visitor;
use App\Models\Page;
use App\Models\Inbox;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HomeResource;
use App\Http\Resources\Frontend\EventResource;
use App\Http\Resources\Frontend\Event2Resource;
use App\Http\Resources\Frontend\PageResource;
use App\Http\Requests\InboxStoreRequest;

class PageController extends Controller
{
    public function index($value='')
    {
        $navigation = Page::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get(); 
        $data = Page::where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->paginate(20);
        $rows = PageResource::collection($data);
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }

    public function show($slug)
    {
        $navigation = Page::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Page::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new PageResource(Page::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
    }

    public function home()
    {
        try {
            Visitor::saveAsVisitor();
        } catch (Exception $e) { }
        
        $row = new HomeResource(Setting::findOrFail(1));
        return response()->json(['row' => $row], 200);
    }


    public function contacts()
    {
        $row = new EventResource(Setting::findOrFail(3));
        return response()->json(['row' => $row], 200);
    }
    public function doContacts(InboxStoreRequest $request)
    {
        $row = Inbox::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    public function events()
    {
        $row = new Event2Resource(Event::findOrFail(1));
        return response()->json(['row' => $row], 200);
    }
}
