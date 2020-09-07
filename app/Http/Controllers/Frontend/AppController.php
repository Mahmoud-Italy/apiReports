<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Imageable;
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
use App\Http\Resources\Frontend\SectorResource;
use App\Http\Resources\Frontend\SectorProductsResource;
use App\Http\Resources\Frontend\PopularSearchResource;
use App\Http\Resources\Frontend\ProfileResource;
use App\Http\Resources\Frontend\MyCertificateResource;
use App\Http\Requests\NewsletterStoreRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\TrainingStoreRequest;


class AppController extends Controller
{
    public function countries()
    {
        $rows = Countries::fetchCountries();
        return response()->json(['rows' => $rows], 200);
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
        $navigation = Accreditation::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $rows = AccreditationResource::collection(Accreditation::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showAccreditations($slug)
    {
        $navigation = Accreditation::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Accreditation::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new AccreditationResource(Accreditation::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
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
        $sectors = SectorResource::collection(
                        Sector::where(['status' => true, 'trash' => false])->paginate(10));
        return response()->json(['row' => $row, 'sectors' => $sectors], 200);
    }
    public function showProducts($slug)
    {
        $page = Product::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row  = new ProductDetailResource(Product::findOrFail(($page->id) ?? 0));
        $related = ProductResource::collection(
                        Product::where(['status' => true, 'trash' => false])
                                ->where('sector_id', $page->sector_id)
                                ->paginate(10));
        return response()->json(['row' => $row, 'related' => $related], 200);
    }


    # Memberships
    public function memberships()
    {
        $navigation = Membership::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $rows = MembershipResource::collection(Membership::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showMemberships($slug)
    {
        $navigation = Membership::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Membership::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new MembershipResource(Membership::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
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
        $navigation = About::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $rows = AboutResource::collection(About::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showabout($slug)
    {
        $navigation = About::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = About::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new AboutResource(About::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
    }    

    # Faq
    public function faqs()
    {
        $navigation = Faq::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $rows = FaqResource::collection(Faq::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showFaqs($slug)
    {
        $navigation = Faq::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Faq::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new FaqResource(Faq::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation,], 200);
    }


    # Privacy Policy
    public function privacy()
    {
        $navigation = Privacy::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $rows = PrivacyResource::collection(Privacy::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showPrivacy($slug)
    {
        $navigation = Privacy::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Privacy::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new PrivacyResource(Privacy::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
    }



    # Online Training
    public function online()
    {
        $navigation = Online::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $rows = OnlineTrainingResource::collection(OnlineTraining::fetchData(request()->all()));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showOnline($slug)
    {
        $navigation = Online::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = OnlineTraining::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new OnlineTrainingResource(OnlineTraining::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
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




    public function updateProfile()
    {
        $user = User::findOrFail(auth()->guard('api')->user()->id);
        $row  = new ProfileResource($user);
        return response()->json(['row' => $row], 200);
    }
    public function updateProfile(Request $request)
    {
        $row             = User::findOrFail(auth()->guard('api')->user()->id);

        if(isset($request->country) && $request->country) {
            $row->country    = $request->country;
        }
        if(isset($request->first_name) && $request->first_name) {
            $row->first_name = $request->first_name;
        }
        if(isset($request->last_name) && $request->last_name) {
            $row->last_name = $request->last_name;
        }
        if(isset($request->ccode) && $request->ccode) {
            $row->ccode = $request->ccode;
        }
        if(isset($request->mobile) && $request->mobile) {
            $row->mobile = $request->mobile;
        }
        if(isset($request->website) && $request->website) {
            $row->website = $request->website;
        }
        if(isset($request->password) && $request->password) {
            $plainPassword  = $request->password;
            $row->password  = app('hash')->make($plainPassword);
        }
        if(isset($request->avatar) && $request->hasFile('avatar')) {
            $image = Imageable::uploadImage($request->file('avatar'));
            $row->image()->delete();
            $row->image()->create(['url' => $image]);
        }
        $row->save();

        return response()->json(['message' => ''], 200);
    }

    public function myCertificates($value='')
    {
        $data = User::where('id', 0)->get(); // tmep
        $row  = MyCertificateResource::collection($data);
        return response()->json(['row' => $row], 200);
    }
}

