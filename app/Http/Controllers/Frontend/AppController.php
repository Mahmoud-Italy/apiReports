<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Search;
use App\Models\Setting;
use App\Models\User;
use App\Models\OnlineTraining as Online;
use App\Models\Imageable;
use App\Models\Certificate;
use App\Models\CertificateProduct;
use App\Models\CertificateCategory;
use App\Models\Faq;
use App\Models\About;
use App\Models\Social;
use App\Models\Program;
use App\Models\Sector;
use App\Models\Product;
use App\Models\Product2;
use App\Models\Privacy;
use App\Models\Subcriber;

use App\Models\Member;
use App\Models\Training;
use App\Models\Instructor;
use App\Models\Experience;

use App\Models\Membership;
use App\Models\Accreditation;
use App\Models\OnlineTraining;
use App\Models\PopularSearch;
use App\Helpers\Countries;
use App\Helpers\Geo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\SearchResource;
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
use App\Http\Resources\Frontend\LogoResource;
use App\Http\Resources\Frontend\SectorProductsResource;
use App\Http\Resources\Frontend\PopularSearchResource;
use App\Http\Resources\Frontend\ProfileResource;
use App\Http\Resources\Frontend\MyCertificateResource;
use App\Http\Resources\Frontend\OurCertificateResource;
use App\Http\Resources\Frontend\SettingResource;
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
        $rows = PopularSearch::select('id', 'title', 'slug')
                                ->whereNULL('parent_id')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        return response()->json(['rows' => $rows], 200);
    }
    public function showpopular($slug)
    {
        $page = PopularSearch::where(['status' => true, 'trash' => false])
                                ->whereNULL('parent_id')
                                ->where('slug', $slug)->first();
        $navigation = PopularSearch::select('id', 'title', 'slug')
                                ->where('parent_id', $page->id)
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        
        $row = new PopularSearchResource(PopularSearch::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
    }
    public function showShortcutPopular($slug)
    {
        $page = PopularSearch::where(['status' => true, 'trash' => false])
                                ->whereNOTNULL('parent_id')
                                ->where('slug', $slug)
                                ->first();
        $navigation = PopularSearch::select('id', 'title', 'slug')
                                ->where('parent_id', $page->parent_id)
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $row = new PopularSearchResource(PopularSearch::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
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
        $page = Accreditation::where(['status' => true, 'trash' => false])->orderBy('sort', 'DESC')->first();
        $row = new AccreditationResource(Accreditation::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
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
    public function trainings()
    {
       $row = new SettingResource(Setting::find(7));
        return response()->json(['row' => $row], 200);
    }


    # Programs
    public function programs()
    {
        $navigation = Program::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $data = Program::where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->paginate(20);
        $rows = ProgramResource::collection($data);
        return response()->json([
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showPrograms($slug)
    {
        $navigation = Program::select('id', 'title', 'slug')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Program::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row  = new ProgramResource(Program::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation' => $navigation], 200);
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
                        Sector::where(['status' => true, 'trash' => false])->orderBy('sort', 'DESC')->paginate(30));
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
        $data = Membership::where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->paginate(20);
        $rows = MembershipResource::collection($data);
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showMemberships($slug)
    {
        $navigation = Membership::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Membership::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new MembershipResource(Membership::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
    }

    public function members()
    {
       $row = new SettingResource(Setting::find(8));
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


    public function doInstructor(MemberStoreRequest $request)
    {
       $row = Instructor::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }
    public function instructor()
    {
       $row = new SettingResource(Setting::find(9));
        return response()->json(['row' => $row], 200);
    }

    public function doExperience(MemberStoreRequest $request)
    {
       $row = Experience::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }
    public function experience()
    {
       $row = new SettingResource(Setting::find(10));
        return response()->json(['row' => $row], 200);
    }
    
    # About
    public function about()
    {
        $navigation = About::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $data = About::where(['status' => true, 'trash' => false])->orderBy('sort', 'DESC')->first();
        //$rows = AboutResource::collection($data);
        $row = new AboutResource($data);
        return response()->json([
            'row'        => $row,
            'navigation'  => $navigation,
            //'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showabout($slug)
    {
        $navigation = About::select('id', 'slug', 'title')
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
        $navigation = Faq::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $data = Faq::where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->paginate(30);
        $rows = FaqResource::collection($data);
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showFaqs($slug)
    {
        $navigation = Faq::select('id', 'slug', 'title')
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
        $data = Privacy::where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->paginate(30);
        $rows = PrivacyResource::collection($data);
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }
    public function showPrivacy($slug)
    {
        $navigation = Privacy::select('id', 'slug', 'title')
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
        $navigation = Online::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = OnlineTraining::where(['status' => true, 'trash' => false])->orderBy('sort','DESC')->first();
        $row = new OnlineTrainingResource(OnlineTraining::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
    }
    public function showOnline($slug)
    {
        $navigation = Online::select('id', 'slug', 'title')
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




    public function profile()
    {
        try {
            $user = User::findOrFail(auth()->guard('api')->user()->id);
            $row  = new ProfileResource($user);
            return response()->json(['row' => $row], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid access_token.'], 500);
        }
    }
    public function updateProfile(Request $request)
    {
        try {
            $row   = User::findOrFail(auth()->guard('api')->user()->id);

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
            if(isset($request->company) && $request->company) {
                $row->company = $request->company;
            }
            if(isset($request->password) && $request->password) {
                $plainPassword  = $request->password;
                $row->password  = app('hash')->make($plainPassword);
            }

            $row->save();
            
            if(isset($request->avatar) && $request->avatar) {
                $image = Imageable::uploadImage($request->avatar);
                $row->image()->delete();
                $row->image()->create(['url' => $image]);
            }

            $row  = new ProfileResource($row);
            return response()->json(['row' => $row], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid access_token.'], 500);
        }
    }

    public function myCertificates($value='')
    {
        try {
            $data  = User::where('id', auth()->guard('api')->user()->id)->where('active', 3)->get(); // tmep
            $rows  = MyCertificateResource::collection($data);
            return response()->json([
                'rows'        => $rows,
                'paginate'    => $this->paginate($rows)
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid access_token.'], 500);
        }
    }


    public function search()
    {
        $data = Search::paginate(30);
        $rows = SearchResource::collection($data);
        return response()->json([
                'rows'        => $rows,
                'paginate'    => $this->paginate($rows)
        ], 200);
    }



    public function ourCertificates($value='')
    {
        $navigation[] = ['id' => 1, 'title' => 'Overview', 'slug' => 'overview'];
        $navigation[] = ['id' => 2, 'title' => 'Certification Types', 'slug' => 'certification_types'];
        $navigation[] = ['id' => 3, 'title' => 'Certification', 'slug' => 'certification'];
        $navigation[] = ['id' => 4, 'title' => 'Online Training', 'slug' => 'online-training'];

        $rows = new OurCertificateResource(Certificate::findOrFail(1));
        return response()->json([
            'rows'        => $rows,
            'navigation'  => $navigation
        ], 200);
    }

    public function ourCertificatesProgram($slug='')
    {
        $navigation = CertificateProduct::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = CertificateProduct::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new ProductDetailResource(CertificateProduct::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
    }


    public function showProgramsPopularSearch($slug='')
    {
        $navigation = Product2::select('id', 'slug', 'title')
                                ->where(['status' => true, 'trash' => false])
                                ->orderBy('sort', 'DESC')
                                ->get();
        $page = Product2::where(['status' => true, 'trash' => false])->where('slug', $slug)->first();
        $row = new ProductDetailResource(Product2::findOrFail(($page->id) ?? 0));
        return response()->json(['row' => $row, 'navigation'  => $navigation], 200);
    }




    public function logo($value='')
    {
        $row = new LogoResource(Setting::findOrFail(5));
        return response()->json(['row' => $row], 200);
    }


    public function find($value='')
    {
        return Geo::ip_info(request()->ip());
    }

    public function setting($value='')
    {
        $logo   = new LogoResource(Setting::findOrFail(5));
        $social = SocialResource::collection(Social::fetchData(request()->all()));
        $header = SettingResource::collection(Setting::whereIN('id', [14,15,16,17,18,19,20,21,22])->get());
        return response()->json(['logo' => $logo, 'social' => $social, 'header' => $header], 200);
    }
}

