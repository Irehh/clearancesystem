<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\userProfileUpdate;
use App\Http\Controllers\ImageController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
    }

public function profileUpdate(userProfileUpdate $request, $id)
{
    $user = User::findorFail($id);
    $validatedData = $request->validated();
    
    if ($user) {
        // Store the old photo path
        $oldPhotoPath = $user->photo;
        $oldbanner = $user->banner;

        
            $user->name = $validatedData['name'];
            $user->phone_number = $validatedData['phone_number'];
            $user->about = $validatedData['about'];
            $user->link = $validatedData['link'];
            $user->location = $validatedData['location'];
            $user->display = $validatedData['display'];
      

        // Save the updated user data
        $user->update();

        request()->session()->flash('success', 'Successfully updated your profile');
    } else {
        request()->session()->flash('error', 'Please try again!');
    }

    return redirect()->back();
}


// public function profileUpdate(userProfileUpdate $request, $id)
// {
//     $user = auth()->user();
//     $validatedData = $request->validated();
//     if($user){
//         $user->update([
//             'name' => $validatedData['name'],
//             'phone_number' => $validatedData['phone_number'],
//             'about' => $validatedData['about'],
//             'link' => $validatedData['link'],
//             'location' => $validatedData['location'],
//             'display' => $validatedData['display'],

//         ]);
    
    
//     if($request->hasFile('photo'))
//     {
//         // Upload the new image
//         $imageController = new ImageController();
//         $newPhoto = $imageController->upload($request, 200, 200, 'photos/1/users');
//         // Update the user's profile with the new image path
//         $user->banner = $newPhoto;

//         $path =  $user->photo;
//         if (File::exists($path)) {
//             File::delete($path);
//         }
//     }
//     if ($request->hasFile('banner')) 
//     {
//         // Upload the new image
//         $imageController = new ImageController();
//         $newPhotoPath = $imageController->profile($request, 200, 200, 'photos/banners');

//         // Update the user's profile with the new image path
//         $user->banner = $newPhotoPath;
//         $path =  $user->photo;
//         if (File::exists($path)) {
//             File::delete($path);
//         }
//     }
//     request()->session()->flash('success', 'Successfully updated your profile');
//     } else {
//         request()->session()->flash('error', 'Please try again!');
//     }

//     return redirect()->back();
// }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }
    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','You can not delete this order now');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Order Successfully deleted');
                }
                else{
                    request()->session()->flash('error','Order can not deleted');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('user.order.show')->with('order',$order);
    }
    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Review Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Post Comment successfully deleted');
            }
            else{
                request()->session()->flash('error','Error occurred please try again');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Post Comment not found');
            return redirect()->back();
        }
    }
    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Comment successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Password successfully changed');
    }

    public function getChildByParent(Request $request)
{
    $category = Category::findOrFail($request->id);
    $child_cat = Category::getChildByParentID($request->id);

    if (count($child_cat) <= 0) {
        return response()->json(['status' => false, 'msg' => '', 'data' => null]);
    } else {
        return response()->json(['status' => true, 'msg' => '', 'data' => $child_cat]);
    }
}


    // public function getChildByParent(Request $request){
    //     return $request->all();
    //     $category=Category::findOrFail($request->id);
    //     $child_cat=Category::getChildByParentID($request->id);
    //     // return $child_cat;
    //     if(count($child_cat)<=0){
    //         return response()->json(['status'=>false,'msg'=>'','data'=>null]);
    //     }
    //     else{
    //         return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
    //     }
    // }

    
}
