<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Faq;
use App\Models\About;
use App\Models\Social;
use App\Models\Program;
use App\Models\Sector;
use App\Models\Product;
use App\Models\Privacy;
use App\Models\Subcriber;
use App\Models\Member;
use App\Models\Training;
use App\Models\Membership;
use App\Models\Accreditation;
use App\Models\OnlineTraining;
use App\Models\PopularSearch;
use App\Helpers\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\FaqResource;
use App\Http\Resources\Frontend\SocialResource;
use App\Http\Resources\Frontend\ProgramResource;
use App\Http\Resources\Frontend\PrivacyResource;
use App\Http\Resources\Frontend\MembershipResource;
use App\Http\Resources\Frontend\AccreditationResource;
use App\Http\Resources\Frontend\OnlineTrainingResource;
use App\Http\Resources\Frontend\AboutResource;
use App\Http\Resources\Frontend\ProductResource;
use App\Http\Resources\Frontend\ProductDetailResource;
use App\Http\Resources\Frontend\SubSectorResource;
use App\Http\Resources\Frontend\SectorProductsResource;
use App\Http\Resources\Frontend\PopularSearchResource;
use App\Http\Requests\NewsletterStoreRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\TrainingStoreRequest;


class AppController extends Controller
{
    public function countries()
    {
        try {
            $rows = App\Helpers\Countries::fetchCountries();
            return response()->json(['rows' => $rows], 200);
        } catch (\Exception $e) {
            dd($e);
        }
        
    }

    # Popular Searchs
    public function popular()
    {
        $rows = PopularSearchResource::collection(PopularSearch::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function search()
    {
        $rows  = ProductResource::collection(Product::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function certificate()
    {
        return response()->json(['message' => 'No data found.'], 500);
    }

    # Accredittions
    public function accreditations()
    {
        $rows = AccreditationResource::collection(Accreditation::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showAccreditations($slug)
    {
        $page = Accreditation::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new AccreditationResource(Accreditation::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }
    public function doTrainings(TrainingStoreRequest $request)
    {
       $row = Training::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }


    # Programs
    public function programs()
    {
        $rows = ProgramResource::collection(Program::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showPrograms($slug)
    {
        $page = Program::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row  = new ProgramResource(Program::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }
    public function showSectors($slug)
    {
        $page = Sector::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row  = new SubSectorResource(Sector::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }
    public function allProducts($slug)
    {
        $page = Sector::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row  = new SectorProductsResource(Sector::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }
    public function showProducts($slug)
    {
        $page = Product::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row  = new ProductDetailResource(Product::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }


    # Memberships
    public function memberships()
    {
        $rows = MembershipResource::collection(Membership::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showMemberships($slug)
    {
        $page = Membership::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new MembershipResource(Membership::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }
    public function doMembers(MemberStoreRequest $request)
    {
       $row = Member::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }
    
    # About
    public function about()
    {
        $rows = AboutResource::collection(About::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showabout($slug)
    {
        $page = About::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new AboutResource(About::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }    

    # Faq
    public function faqs()
    {
        $rows = FaqResource::collection(Faq::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showFaqs($slug)
    {
        $page = Faq::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new FaqResource(Faq::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }


    # Privacy Policy
    public function privacy()
    {
        $rows = PrivacyResource::collection(Privacy::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showPrivacy($slug)
    {
        $page = Privacy::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new PrivacyResource(Privacy::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }



    # Online Training
    public function online()
    {
        $rows = OnlineTrainingResource::collection(OnlineTraining::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showOnline($slug)
    {
        $page = OnlineTraining::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new OnlineTrainingResource(OnlineTraining::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row], 200);
    }


    # Newsltter
    public function newsletters(SubcriberStoreRequest $request)
    {
        $row = Subcriber::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    # Social Network
    public function socials()
    {
        $rows = SocialResource::collection(Social::fetchData(request()->all()));
        return response()->json(['rows' => $rows], 200);
    }
}
