<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    VolunteerController,
    MembersController,
    DonorController,
    KalakshepamController,
    GeneralUserController,
    ExtrasController,
    ApprovalrequestController,
    ServicesController,
    CourseController,
    LessonController,
    StudentsController,
    TutorialCategoryController,
    TutorialAudioController,
    TutorialVideoController,
    RmUpanyasamCategoryController,
    RmUpanyasamAudioController,
    RmUpanyasamVideoController,
    DharmaSandhehaThreadsController,
    DharmaSandhehaRepliesController,
    KinchitEnpaniCategoryController,
    KinchitEnpaniAudioController,
    ManageCommunityController,
    ManageSubsectionController,
    ManageCountryController,
    ManageStateController,
    ManageCityController,
    ManageEducationController,
    ManageOccupationController,
    ExpressInterestController,
    ManageSuccessStoriesController,
    ManageMatrimonyProfilesController,
    ManageMatrimonyPhotoApprovalController,
    ReportsController,
    RdBookingController,
    FaqController,
    GnanakaithaRequestController,
    MyprofileController,
    DeliveryrequestController,
    DepositController,
    DonationController,
    GalleryController,
    SpecialProgrammeCategoryController,
    SpecialProgrammeContentController,
    SanchikaCategoryController,
    SanchikaContentController,
    DonationCategoryController,
    kinchitServiceController,
    HomePageController
};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['get', 'post'], '/', array(
    'uses' => 'App\Http\Controllers\IndexController@index',
    'as' => 'index'
));

Route::match(['get', 'post'], '/login-verify', array(
    'uses' => 'App\Http\Controllers\IndexController@loginverify',
    'as' => 'login-verify'
));

Route::get("logout", "App\Http\Controllers\IndexController@logout");

Route::match(['get', 'post'], '/forgetpassword', array(
    'uses' => 'App\Http\Controllers\IndexController@forgetpassword',
    'as' => 'forgetpassword'
));

Route::match(['get', 'post'], '/verifyemailid', array(
    'uses' => 'App\Http\Controllers\IndexController@verifyemailid',
    'as' => 'verifyemailid'
));

Route::match(['get', 'post'], '/verifysuperadminemail', array(
    'uses' => 'App\Http\Controllers\IndexController@verifysuperadminemail',
    'as' => 'verifysuperadminemail'
));

Route::middleware(['user.check'])->group(function () {

    Route::match(['get', 'post'], '/dashboard', array(
        'uses' => 'App\Http\Controllers\DashboardController@index',
        'as' => 'dashboard'
    ));
    Route::match(['get', 'post'], '/myprofile/{id}', array(
        'uses' => 'App\Http\Controllers\MyprofileController@myprofile',
        'as' => 'myprofile'
    ));

    Route::post('get-requesttypes', [ExtrasController::class, 'GetRequestTypes'])->name('get-requesttypes.index');
    Route::get('/setting/change-password', [ExtrasController::class, 'ChangePasswordPage']);
    Route::post('change-password', [ExtrasController::class, 'ChangePassword'])->name('change-password.index');
    Route::get('/setting/site-configuration', [ExtrasController::class, 'SiteConfigurationPage']);
    Route::post('update-site-configuration', [ExtrasController::class, 'UpdateSiteConfigurations'])->name('update-site-configuration.index');
    Route::get('/setting/seo-metas', [ExtrasController::class, 'SeoConfigurationPage']);
    Route::post('update-seo-configuration', [ExtrasController::class, 'UpdateSeoConfigurations'])->name('update-seo-configuration.index');

    Route::get('/volunteers', [VolunteerController::class, 'index']);
    Route::post('get-volunteers', [VolunteerController::class, 'ShowVolunteer'])->name('show-volunteer.index');
    Route::get('/members/{id}', [VolunteerController::class, 'MemberIndex'])->name('show-bel-member.index');
    Route::get('/user-profile/edit/{id}', [VolunteerController::class, 'EditTheUserProfile'])->name('edit-the-user-profile.index');
    Route::post('update-user-datas', [VolunteerController::class, 'UpdateTheDataOfUser'])->name('update-user-datas.index');
    Route::post('delete-user-image', [VolunteerController::class, 'DeleteTheUserImage'])->name('delete-user-image.index');
    Route::post('members-post', [VolunteerController::class, 'ShowMemberBelowVolunteer'])->name('show-bel-member-post.index');
    Route::post('sent-request', [VolunteerController::class, 'ApprovalRequest'])->name('approval-request.store');
    Route::get('/create-user-profile', [VolunteerController::class, 'CreateTheUserProfile'])->name('create-user-profile.index');
    Route::post('create-the-user-profile', [VolunteerController::class, 'CreateTheDataOfUser'])->name('create-the-user-profile.index');

    Route::get('/members', [MembersController::class, 'index']);
    Route::post('get-members', [MembersController::class, 'ShowMember'])->name('show-member.index');
    Route::post('status-members', [MembersController::class, 'ChangeMemberStatus'])->name('status-member.index');

    Route::get('/donors', [DonorController::class, 'index']);
    Route::post('get-donors', [DonorController::class, 'ShowDonors'])->name('show-donor.index');

    Route::get('/kalakshepem', [KalakshepamController::class, 'index']);
    Route::post('get-datas', [KalakshepamController::class, 'ShowData'])->name('get-datas.kalakshepam');

    Route::get('/general-users', [GeneralUserController::class, 'index']);
    Route::post('get-users-datas', [GeneralUserController::class, 'ShowData'])->name('get-users-datas.user');

    Route::get('/approval-requests', [ApprovalrequestController::class, 'index']);
    Route::post('get-requests-list', [ApprovalrequestController::class, 'ShowApprovalRequestlist'])->name('show-requests.index');
    Route::post('get-requests-type', [ApprovalrequestController::class, 'GettheRequesttype'])->name('get-requests.index');
    Route::post('onevol-anothervol', [ApprovalrequestController::class, 'ChangeMembersTo_an_Volunteer'])->name('one-to-another.post');
    Route::post('change-volunteer', [ApprovalrequestController::class, 'ChangeVolunteerForMemeber'])->name('change-volunteer.post');
    Route::post('inactive-user', [ApprovalrequestController::class, 'InactiveUserByRequested'])->name('inactive-user.post');
    Route::post('Change-to-member', [ApprovalrequestController::class, 'ChangeDonorToMember'])->name('Change-to-member.post');
    Route::post('approve-to-be-volunteer', [ApprovalrequestController::class, 'AprroveToBeAVolunteer'])->name('approve-to-be-volunteer.post');
    Route::post('reject-request', [ApprovalrequestController::class, 'RejectRequest'])->name('reject-request.post');
    Route::get('/approved-requests', [ApprovalrequestController::class, 'ApprovedRequests']);
    Route::get('/rejected-requests', [ApprovalrequestController::class, 'RejectedRequests']);
    Route::get('/challan-requests', [ApprovalrequestController::class, 'ChallanRequest']);
    Route::get('/approve-request-view/{id}', [ApprovalrequestController::class, 'ApproveRequestsView'])->name('approve-request-view');
    Route::post('onemem-anothermem', [ApprovalrequestController::class, 'ChangeToMember'])->name('one-to-another-member.post');

    Route::get('/services', [ServicesController::class, 'index']);
    Route::post('create-service-article', [ServicesController::class, 'CreateServiceArticle'])->name('create-service-article.service');
    Route::post('get-list-service', [ServicesController::class, 'GetServicesList'])->name('get-list-service.service');
    Route::post('service-change-status', [ServicesController::class, 'ChangeServicesStatus'])->name('service-change-status.service');
    Route::post('get-service-data', [ServicesController::class, 'GetDatasOf_A_Service'])->name('get-service-data.service');
    Route::post('update-service-data', [ServicesController::class, 'UpdateTheDataOfService'])->name('update-service-data.service');
    Route::post('delete-data-service', [ServicesController::class, 'DeleteTheService'])->name('delete-data-service.service');
    Route::get('/services/{id}', [ServicesController::class, 'ShowServiceContentsPage'])->name('service-content.service');
    Route::post('create-service-content', [ServicesController::class, 'CreateServiceContent'])->name('create-service-content.service');
    Route::post('get-service-content-list', [ServicesController::class, 'GetServiceContentList'])->name('get-service-content-list.service');
    Route::post('service-content-change-status', [ServicesController::class, 'ChangeServiceContentStatus'])->name('service-content-change-status.service');
    Route::post('get-service-content-data', [ServicesController::class, 'GetDatasOf_A_Service_Content'])->name('get-service-content-data.service');
    Route::post('update-service-content-data', [ServicesController::class, 'UpdateTheDataOfServiceContent'])->name('update-service-content-data.service');
    Route::post('delete-service-content-data', [ServicesController::class, 'DeleteTheServiceContent'])->name('delete-service-content-data.service');
    Route::post('service-content-image-upload', [ServicesController::class, 'ServiceContentImageUpload'])->name('service-content-image-upload.service');
    Route::post('get-service-content-images', [ServicesController::class, 'GetServiceContentImages'])->name('get-service-content-images.service');
    Route::post('delete-service-content-image', [ServicesController::class, 'DeleteTheServiceContentImage'])->name('delete-service-content-image.service');

    Route::get('/services-test', [ServicesController::class, 'index123']);

    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('get-courses', [CourseController::class, 'ShowCourses'])->name('get-courses.course');
    Route::get('/create-course', [CourseController::class, 'CreatePage'])->name('create-course-page.course');
    Route::post('create-the-course', [CourseController::class, 'CreateTheCourse'])->name('create-the-course.course');
    Route::get('/course/edit/{id}', [CourseController::class, 'ShowEditPage'])->name('edit-course-page.course');
    Route::post('update-the-course', [CourseController::class, 'UpdateTheCourse'])->name('update-the-course.course');
    Route::post('delete-course-data', [CourseController::class, 'DeleteTheCourse'])->name('delete-course-data.course');
    Route::post('delete-the-course-image', [CourseController::class, 'DeleteTheCourseImage'])->name('delete-the-course-image.course');
    Route::post('delete-the-course-pdf', [CourseController::class, 'DeleteTheCoursePDF'])->name('delete-the-course-pdf.course');
    Route::post('update-the-course-status', [CourseController::class, 'UpdateTheStatusOfCourse'])->name('update-the-course-status.course');

    Route::get('/lessons', [LessonController::class, 'index']);
    Route::post('get-lessons', [LessonController::class, 'ShowLessons'])->name('get-lessons.lessons');
    Route::get('/create-lesson', [LessonController::class, 'CreatePage'])->name('create-lesson-page.lesson');
    Route::post('create-the-lesson', [LessonController::class, 'CreateThelesson'])->name('create-the-lesson.lesson');
    Route::get('/lesson/edit/{id}', [LessonController::class, 'ShowEditPage'])->name('edit-lesson-page.lesson');
    Route::post('update-the-lesson', [LessonController::class, 'UpdateThelesson'])->name('update-the-lesson.lesson');
    Route::post('delete-lesson-data', [LessonController::class, 'DeleteTheLesson'])->name('delete-lesson-data.lesson');

    Route::get('/students', [StudentsController::class, 'index']);
    Route::post('get-students', [StudentsController::class, 'GetTheStudentsForCourse'])->name('get-students.student');
    Route::post('get-students-filter', [StudentsController::class, 'GetStudentsWithFilter'])->name('get-students-filter.student');
    Route::post('assign-course-for-student', [StudentsController::class, 'AssignCourseForStudent'])->name('assign-course-for-student.student');
    Route::post('remove-course-for-student', [StudentsController::class, 'RemoveCourseForStudent'])->name('remove-course-for-student.student');
    Route::post('change-course-for-student-status', [StudentsController::class, 'ChangeStatus'])->name('change-course-for-student-status.student');

    Route::get('/tutorial-albums', [TutorialCategoryController::class, 'index']);
    Route::post('get-category-list', [TutorialCategoryController::class, 'ShowCategoryList'])->name('show-category-list.tut_category');
    Route::post('create-tutorial-category', [TutorialCategoryController::class, 'CreateTutorialCategory'])->name('create-tutorial-category.tut_category');
    Route::post('get-tutorial-category-data', [TutorialCategoryController::class, 'GetDatasOf_A_TutorialCategory'])->name('get-tutorial-category-data.tut_category');
    Route::post('update-tutorial-category-data', [TutorialCategoryController::class, 'UpdateTheDataOfTutorialCategory'])->name('update-tutorial-category-data.tut_category');
    Route::post('update-tutorial-category-sortorder', [TutorialCategoryController::class, 'UpdateTheSortOrderOfTutorialCategory'])->name('update-tutorial-category-sortorder.tut_category');
    Route::post('delete-tutorial-category-data', [TutorialCategoryController::class, 'DeleteTheTutorialCategory'])->name('delete-tutorial-category-data.tut_category');

    Route::get('/tutorial-audios', [TutorialAudioController::class, 'index']);
    Route::post('get-tutorial-audios', [TutorialAudioController::class, 'ShowTutotialAudios'])->name('get-tutorial-audios.tut_audio');
    Route::get('/create-tutorial-audio', [TutorialAudioController::class, 'CreatePage'])->name('create-tutorial-audio.tut_audio');
    Route::post('get-tutorial-audio-track', [TutorialAudioController::class, 'GetTutorialAudioTrack'])->name('get-tutorial-audio-track.tut_audio');
    Route::post('create-the-tutorial-audio', [TutorialAudioController::class, 'CreateTheTutorialAudio'])->name('create-the-tutorial-audio.tut_audio');
    Route::get('/tutorial-audio/edit/{id}', [TutorialAudioController::class, 'ShowEditPage'])->name('edit-tutorial-audio-page.tut_audio');
    Route::post('update-the-tutorial-audio', [TutorialAudioController::class, 'UpdateTheTutorialAudio'])->name('update-the-tutorial-audio.tut_audio');
    Route::post('update-tutorial-audio-sortorder', [TutorialAudioController::class, 'UpdateTheSortOrderOfTutorialCategory'])->name('update-tutorial-audio-sortorder.tut_audio');
    Route::post('delete-tutorial-audio-data', [TutorialAudioController::class, 'DeleteTheTutorialAudio'])->name('delete-tutorial-audio-data.tut_audio');

    Route::get('/tutorial-videos', [TutorialVideoController::class, 'index']);
    Route::post('get-tutorial-videos', [TutorialVideoController::class, 'ShowTutotialVideo'])->name('get-tutorial-videos.tut_video');
    Route::get('/create-tutorial-video', [TutorialVideoController::class, 'CreatePage'])->name('create-tutorial-video.tut_video');
    Route::post('create-the-tutorial-video', [TutorialVideoController::class, 'CreateTheTutorialVideo'])->name('create-the-tutorial-video.tut_video');
    Route::get('/tutorial-video/edit/{id}', [TutorialVideoController::class, 'ShowEditPage'])->name('edit-tutorial-video-page.tut_video');
    Route::post('update-the-tutorial-video', [TutorialVideoController::class, 'UpdateTheTutorialVideo'])->name('update-the-tutorial-video.tut_video');
    Route::post('delete-tutorial-video-data', [TutorialVideoController::class, 'DeleteTheTutorialVideo'])->name('delete-tutorial-video-data.tut_video');

    Route::get('/rm-albums', [RmUpanyasamCategoryController::class, 'index']);
    Route::post('get-category-list-rm', [RmUpanyasamCategoryController::class, 'ShowCategoryList'])->name('show-category-list.rm_category');
    Route::post('create-rm-category', [RmUpanyasamCategoryController::class, 'CreateTutorialCategory'])->name('create-rm-category.rm_category');
    Route::post('get-rm-category-data', [RmUpanyasamCategoryController::class, 'GetDatasOf_A_TutorialCategory'])->name('get-rm-category-data.rm_category');
    Route::post('update-rm-category-data', [RmUpanyasamCategoryController::class, 'UpdateTheDataOfTutorialCategory'])->name('update-rm-category-data.rm_category');
    Route::post('delete-rm-category-data', [RmUpanyasamCategoryController::class, 'DeleteTheTutorialCategory'])->name('delete-rm-category-data.rm_category');

    Route::get('/rm-audios', [RmUpanyasamAudioController::class, 'index']);
    Route::post('get-rm-audios', [RmUpanyasamAudioController::class, 'ShowRMAudios'])->name('get-rm-audios.rm_audio');
    Route::get('/create-rm-audio', [RmUpanyasamAudioController::class, 'CreatePage'])->name('create-rm-audio.rm_audio');
    Route::post('create-the-rm-audio', [RmUpanyasamAudioController::class, 'CreateTheRmOnlineUpanyasamAudio'])->name('create-the-rm-audio.rm_audio');
    Route::post('get-rm-parent-audio', [RmUpanyasamAudioController::class, 'GetRmParentAudio'])->name('get-rm-parent-audio.rm_audio');
    Route::get('/rm-audio/edit/{id}', [RmUpanyasamAudioController::class, 'ShowEditPage'])->name('edit-rm-audio-page.rm_audio');
    Route::post('update-the-rmonline-audio', [RmUpanyasamAudioController::class, 'UpdateTheRmOnlineAudio'])->name('update-the-rmonline-audio.rm_audio');
    Route::post('delete-rmonline-audio-data', [RmUpanyasamAudioController::class, 'DeleteTheRmOnlineAudio'])->name('delete-rmonline-audio-data.rm_audio');

    Route::get('/rm-videos', [RmUpanyasamVideoController::class, 'index']);
    Route::post('get-rmonline-videos', [RmUpanyasamVideoController::class, 'ShowRMOnlineVideo'])->name('get-rmonline-videos.rm_video');
    Route::get('/create-rmonline-video', [RmUpanyasamVideoController::class, 'CreatePage'])->name('create-rmonline-video.rm_video');
    Route::post('create-the-rmonline-video', [RmUpanyasamVideoController::class, 'CreateTheRMOnlineUpanyasamVideo'])->name('create-the-rmonline-video.rm_video');
    Route::get('/rm-video/edit/{id}', [RmUpanyasamVideoController::class, 'ShowEditPage'])->name('edit-rmonline-video-page.rm_video');
    Route::post('update-the-rmonline-video', [RmUpanyasamVideoController::class, 'UpdateTheRMOnlineVideo'])->name('update-the-rmonline-video.rm_video');
    Route::post('delete-rmonline-video-data', [RmUpanyasamVideoController::class, 'DeleteTheRMOnlineVideo'])->name('delete-rmonline-video-data.rm_video');

    Route::get('/threads', [DharmaSandhehaThreadsController::class, 'index']);
    Route::post('get-threads', [DharmaSandhehaThreadsController::class, 'ShowThreads'])->name('get-threads.thread');
    Route::get('/create-thread', [DharmaSandhehaThreadsController::class, 'CreatePage'])->name('create-thread-page.thread');
    Route::post('create-the-thread', [DharmaSandhehaThreadsController::class, 'CreateTheThread'])->name('create-the-thread.thread');
    Route::get('/thread/edit/{id}', [DharmaSandhehaThreadsController::class, 'ShowEditPage'])->name('edit-thread-page.thread');
    Route::post('update-the-thread', [DharmaSandhehaThreadsController::class, 'UpdateTheThread'])->name('update-the-thread.thread');
    Route::post('change-the-status-of-thread', [DharmaSandhehaThreadsController::class, 'ChangeThePostStatusOfThread'])->name('change-the-status-of-thread.thread');
    Route::post('delete-thread-data', [DharmaSandhehaThreadsController::class, 'DeleteTheThread'])->name('delete-thread-data.thread');

    Route::get('/replies', [DharmaSandhehaRepliesController::class, 'index']);
    Route::post('get-replies', [DharmaSandhehaRepliesController::class, 'ShowReplies'])->name('show-replies.reply');
    Route::post('get-threads-for-filter', [DharmaSandhehaRepliesController::class, 'GetThreadsListForFilter'])->name('get-threads-for-filter.reply');
    Route::get('/create-reply', [DharmaSandhehaRepliesController::class, 'CreatePage'])->name('create-reply-page.reply');
    Route::post('create-the-reply', [DharmaSandhehaRepliesController::class, 'CreateTheReplies'])->name('create-the-reply.reply');
    Route::get('/reply/edit/{id}', [DharmaSandhehaRepliesController::class, 'ShowEditPage'])->name('edit-reply-page.reply');
    Route::post('update-the-reply', [DharmaSandhehaRepliesController::class, 'UpdateTheReply'])->name('update-the-reply.reply');
    Route::post('change-the-status-of-reply', [DharmaSandhehaRepliesController::class, 'ChangeThePostStatusOfReply'])->name('change-the-status-of-reply.reply');
    Route::post('delete-reply-data', [DharmaSandhehaRepliesController::class, 'DeleteTheReply'])->name('delete-reply-data.reply');

    Route::get('/enpani-categories', [KinchitEnpaniCategoryController::class, 'index']);
    Route::post('get-enpani-category-list', [KinchitEnpaniCategoryController::class, 'ShowCategoryList'])->name('show-enpani-category-list.enpani_category');
    Route::post('create-enpani-category', [KinchitEnpaniCategoryController::class, 'CreateEnpaniCategory'])->name('create-enpani-category.enpani_category');
    Route::post('get-enpani-category-data', [KinchitEnpaniCategoryController::class, 'GetDataOf_A_EnpaniCategory'])->name('get-enpani-category-data.enpani_category');
    Route::post('update-enpani-category-data', [KinchitEnpaniCategoryController::class, 'UpdateTheDataOfEnpaniCategory'])->name('update-enpani-category-data.enpani_category');
    Route::post('delete-enpani-category-data', [KinchitEnpaniCategoryController::class, 'DeleteTheEnpaniCategory'])->name('delete-enpani-category-data.enpani_category');

    Route::get('/enpani-audios', [KinchitEnpaniAudioController::class, 'index']);
    Route::post('get-enpani-audios', [KinchitEnpaniAudioController::class, 'ShowEnpaniAudios'])->name('get-enpani-audios.enpani_audio');
    Route::get('/create-enpani-audio', [KinchitEnpaniAudioController::class, 'CreatePage'])->name('create-enpani-audio.enpani_audio');
    Route::post('create-the-enpani-audio', [KinchitEnpaniAudioController::class, 'CreateTheEnpaniAudio'])->name('create-the-enpani-audio.enpani_audio');
    Route::get('/enpani-audio/edit/{id}', [KinchitEnpaniAudioController::class, 'ShowEditPage'])->name('edit-enpani-audio-page.enpani_audio');
    Route::post('update-the-enpani-audio', [KinchitEnpaniAudioController::class, 'UpdateTheEnpaniAudio'])->name('update-the-enpani-audio.enpani_audio');
    Route::post('delete-enpani-audio-data', [KinchitEnpaniAudioController::class, 'DeleteTheEnpaniAudio'])->name('delete-enpani-audio-data.enpani_audio');

    Route::get('/lakshmi-kalyanam/manage-community', [ManageCommunityController::class, 'index']);
    Route::post('get-manage-community', [ManageCommunityController::class, 'ShowList'])->name('get-manage-community.laksh_community');
    Route::post('change-community-status', [ManageCommunityController::class, 'ChangeStatus'])->name('change-community-status.laksh_community');
    Route::post('delete-community-data', [ManageCommunityController::class, 'DeleteTheData'])->name('delete-community-data.laksh_community');
    Route::post('create-the-community', [ManageCommunityController::class, 'CreateData'])->name('create-the-community.laksh_community');
    Route::post('get-the-community', [ManageCommunityController::class, 'GetEditData'])->name('get-the-community.laksh_community');
    Route::post('update-the-community', [ManageCommunityController::class, 'UpdateData'])->name('update-the-community.laksh_community');

    Route::get('/lakshmi-kalyanam/manage-subsection', [ManageSubsectionController::class, 'index']);
    Route::post('get-manage-subsection', [ManageSubsectionController::class, 'ShowList'])->name('get-manage-subsection.laksh_subsection');
    Route::post('change-subsection-status', [ManageSubsectionController::class, 'ChangeStatus'])->name('change-subsection-status.laksh_subsection');
    Route::post('delete-subsection-data', [ManageSubsectionController::class, 'DeleteTheData'])->name('delete-subsection-data.laksh_subsection');
    Route::post('create-the-subsection', [ManageSubsectionController::class, 'CreateData'])->name('create-the-subsection.laksh_subsection');
    Route::post('get-the-subsection', [ManageSubsectionController::class, 'GetEditData'])->name('get-the-subsection.laksh_subsection');
    Route::post('update-the-subsection', [ManageSubsectionController::class, 'UpdateData'])->name('update-the-subsection.laksh_subsection');

    Route::get('/lakshmi-kalyanam/manage-country', [ManageCountryController::class, 'index']);
    Route::post('get-manage-country', [ManageCountryController::class, 'ShowList'])->name('get-manage-country.laksh_country');
    Route::post('change-country-status', [ManageCountryController::class, 'ChangeStatus'])->name('change-country-status.laksh_country');
    Route::post('delete-country-data', [ManageCountryController::class, 'DeleteTheData'])->name('delete-country-data.laksh_country');
    Route::post('create-the-country', [ManageCountryController::class, 'CreateData'])->name('create-the-country.laksh_country');
    Route::post('get-the-country', [ManageCountryController::class, 'GetEditData'])->name('get-the-country.laksh_country');
    Route::post('update-the-country', [ManageCountryController::class, 'UpdateData'])->name('update-the-country.laksh_country');

    Route::get('/lakshmi-kalyanam/manage-state', [ManageStateController::class, 'index']);
    Route::post('get-manage-state', [ManageStateController::class, 'ShowList'])->name('get-manage-state.laksh_state');
    Route::post('change-state-status', [ManageStateController::class, 'ChangeStatus'])->name('change-state-status.laksh_state');
    Route::post('delete-state-data', [ManageStateController::class, 'DeleteTheData'])->name('delete-state-data.laksh_state');
    Route::post('create-the-state', [ManageStateController::class, 'CreateData'])->name('create-the-state.laksh_state');
    Route::post('get-the-state', [ManageStateController::class, 'GetEditData'])->name('get-the-state.laksh_state');
    Route::post('update-the-state', [ManageStateController::class, 'UpdateData'])->name('update-the-state.laksh_state');

    Route::get('/lakshmi-kalyanam/manage-city', [ManageCityController::class, 'index']);
    Route::post('get-manage-city', [ManageCityController::class, 'ShowList'])->name('get-manage-city.laksh_city');
    Route::post('change-city-status', [ManageCityController::class, 'ChangeStatus'])->name('change-city-status.laksh_city');
    Route::post('delete-city-data', [ManageCityController::class, 'DeleteTheData'])->name('delete-city-data.laksh_city');
    Route::post('create-the-city', [ManageCityController::class, 'CreateData'])->name('create-the-city.laksh_city');
    Route::post('get-the-city', [ManageCityController::class, 'GetEditData'])->name('get-the-city.laksh_city');
    Route::post('update-the-city', [ManageCityController::class, 'UpdateData'])->name('update-the-city.laksh_city');

    Route::get('/lakshmi-kalyanam/manage-education', [ManageEducationController::class, 'index']);
    Route::post('get-manage-education', [ManageEducationController::class, 'ShowList'])->name('get-manage-education.laksh_education');
    Route::post('change-education-status', [ManageEducationController::class, 'ChangeStatus'])->name('change-education-status.laksh_education');
    Route::post('delete-education-data', [ManageEducationController::class, 'DeleteTheData'])->name('delete-education-data.laksh_education');
    Route::post('create-the-education', [ManageEducationController::class, 'CreateData'])->name('create-the-education.laksh_education');
    Route::post('get-the-education', [ManageEducationController::class, 'GetEditData'])->name('get-the-education.laksh_education');
    Route::post('update-the-education', [ManageEducationController::class, 'UpdateData'])->name('update-the-education.laksh_education');

    Route::get('/lakshmi-kalyanam/manage-occupation', [ManageOccupationController::class, 'index']);
    Route::post('get-manage-occupation', [ManageOccupationController::class, 'ShowList'])->name('get-manage-occupation.laksh_occupation');
    Route::post('change-occupation-status', [ManageOccupationController::class, 'ChangeStatus'])->name('change-occupation-status.laksh_occupation');
    Route::post('delete-occupation-data', [ManageOccupationController::class, 'DeleteTheData'])->name('delete-occupation-data.laksh_occupation');
    Route::post('create-the-occupation', [ManageOccupationController::class, 'CreateData'])->name('create-the-occupation.laksh_occupation');
    Route::post('get-the-occupation', [ManageOccupationController::class, 'GetEditData'])->name('get-the-occupation.laksh_occupation');
    Route::post('update-the-occupation', [ManageOccupationController::class, 'UpdateData'])->name('update-the-occupation.laksh_occupation');

    Route::get('/lakshmi-kalyanam/express-interest', [ExpressInterestController::class, 'index']);
    Route::post('get-express-interest', [ExpressInterestController::class, 'ShowList'])->name('get-express-interest.express_interest');

    Route::get('/lakshmi-kalyanam/success-stories', [ManageSuccessStoriesController::class, 'index']);
    Route::post('get-success-stories', [ManageSuccessStoriesController::class, 'ShowSuccessStories'])->name('get-success-stories.success_story');
    Route::get('/lakshmi-kalyanam/create-success-story', [ManageSuccessStoriesController::class, 'CreatePage'])->name('create-success-story.success_story');
    Route::post('create-the-success-story', [ManageSuccessStoriesController::class, 'CreateTheSuccessStory'])->name('create-the-success-story.success_story');
    Route::get('/success-stories/edit/{id}', [ManageSuccessStoriesController::class, 'ShowEditPage'])->name('edit-success-story-page.success_story');
    Route::post('update-the-success-story', [ManageSuccessStoriesController::class, 'UpdateTheSuccessStory'])->name('update-the-success-story.success_story');
    Route::post('status-of-the-success-story', [ManageSuccessStoriesController::class, 'ChangeTheStatusOfSuccessStory'])->name('status-of-the-success-story.success_story');
    Route::post('delete-the-image', [ManageSuccessStoriesController::class, 'DeleteTheImage'])->name('delete-the-image.success_story');
    Route::post('delete-success-story-data', [ManageSuccessStoriesController::class, 'DeleteTheSuccessStory'])->name('delete-success-story-data.success_story');

    Route::get('/lakshmi-kalyanam/profiles', [ManageMatrimonyProfilesController::class, 'index']);
    Route::post('get-matrimony-profiles', [ManageMatrimonyProfilesController::class, 'ShowMatrimonyProfiles'])->name('get-matrimony-profiles.laksh_profile');
    Route::post('get-sub-section', [ManageMatrimonyProfilesController::class, 'GetTheSubsectioon'])->name('get-sub-section.laksh_profile');
    Route::get('/lakshmi-kalyanam/create-profile', [ManageMatrimonyProfilesController::class, 'CreatePage'])->name('create-profile.laksh_profile');
    Route::post('create-the-profile', [ManageMatrimonyProfilesController::class, 'CreateTheProfile'])->name('create-the-profile.laksh_profile');
    Route::post('status-of-profiles', [ManageMatrimonyProfilesController::class, 'ChangeTheStatusOfProfile'])->name('status-of-profiles.laksh_profile');
    Route::get('/lakshmi-kalyanam-profile/edit/{id}', [ManageMatrimonyProfilesController::class, 'ShowEditPage'])->name('edit-lakshmi-kalyanam-profile-page.laksh_profile');
    Route::post('update-the-profile', [ManageMatrimonyProfilesController::class, 'UpdateTheProfile'])->name('update-the-profile.laksh_profile');
    Route::post('delete-profile-data', [ManageMatrimonyProfilesController::class, 'DeleteTheProfile'])->name('delete-profile-data.laksh_profile');

    Route::get('/lakshmi-kalyanam/photo-approval', [ManageMatrimonyPhotoApprovalController::class, 'index']);
    Route::post('get-photo-approval-images', [ManageMatrimonyPhotoApprovalController::class, 'ShowRequestedImages'])->name('get-photo-approval-images.pt_approval');
    Route::post('approve-images', [ManageMatrimonyPhotoApprovalController::class, 'ApproveRequest'])->name('approve-images.pt_approval');
    Route::post('reject-images', [ManageMatrimonyPhotoApprovalController::class, 'RejectRequest'])->name('reject-images.pt_approval');

    Route::get('/reports/user-report', [ReportsController::class, 'index']);
    Route::get('/generate-user-report', [ReportsController::class, 'GenerateUserReport'])->name('generate-user-report.report');

    Route::get('/rd-booking', [RdBookingController::class, 'index']);
    Route::post('get-booking-datas', [RdBookingController::class, 'ShowData'])->name('get-booking-datas.rdbooking');
    Route::get('/create-booking', [RdBookingController::class, 'BookingCreatePage']);
    Route::post('book-the-rd-booking', [RdBookingController::class, 'StoreTheBookingFromRD'])->name('book-the-rd-booking.rdbooking');
    Route::get('/book-detail/{id}', [RdBookingController::class, 'ShowBookingDetails']);
    Route::post('updatebook-the-rd-booking', [RdBookingController::class, 'UpdateTheBookingFromRD'])->name('updatebook-the-rd-booking.rdbooking');
    Route::post('delete-booking', [RdBookingController::class, 'DeleteData'])->name('delete-booking.rdbooking');

    Route::get('/faq', [FaqController::class, 'index']);
    Route::post('get-faq-list', [FaqController::class, 'ShowList'])->name('get-faq-list.faq');
    Route::post('delete-faq-data', [FaqController::class, 'DeleteTheData'])->name('delete-faq-data.faq');
    Route::post('create-the-faq', [FaqController::class, 'CreateData'])->name('create-the-faq.faq');
    Route::post('get-the-faq', [FaqController::class, 'GetEditData'])->name('get-the-faq.faq');
    Route::post('update-the-faq', [FaqController::class, 'UpdateData'])->name('update-the-faq.faq');

    Route::get('/gnanakaitha', [GnanakaithaRequestController::class, 'index']);
    Route::post('get-gnanakaitha-requests', [GnanakaithaRequestController::class, 'ShowGnanakaithaRequestlist'])->name('get-gnanakaitha-requests.gnanakaitha');
    Route::get('/gnanakaithaa/{id}', [GnanakaithaRequestController::class, 'ShowOneData']);
    Route::post('verify-gnanakaitha-request', [GnanakaithaRequestController::class, 'VerifyTheRequest'])->name('verify-gnanakaitha-request.gnanakaitha');
    Route::post('approve-gnanakaitha-request', [GnanakaithaRequestController::class, 'ApproveTheRequest'])->name('approve-gnanakaitha-request.gnanakaitha');
    Route::post('reject-gnanakaitha-request', [GnanakaithaRequestController::class, 'RejectTheRequest'])->name('reject-gnanakaitha-request.gnanakaitha');
    Route::get('/approved-gnanakaitha', [GnanakaithaRequestController::class, 'ApprovedListPage']);
    Route::get('/rejected-gnanakaitha', [GnanakaithaRequestController::class, 'RejectedListPage']);
    Route::post('get-approved-gnanakaitha-requests', [GnanakaithaRequestController::class, 'ApprovedList'])->name('get-approved-gnanakaitha-requests.gnanakaitha');
    Route::post('get-rejected-gnanakaitha-requests', [GnanakaithaRequestController::class, 'RejectedList'])->name('get-rejected-gnanakaitha-requests.gnanakaitha');
    Route::post('delete-gnanakaitha-request', [GnanakaithaRequestController::class, 'DeleteTheRequest'])->name('delete-gnanakaitha-request.gnanakaitha');

    // my profile controller
    Route::post('update-user-data', [MyprofileController::class, 'UpdateMyProfile'])->name('update-my-profile');

    Route::get('/delivery-pending-requests', [DeliveryrequestController::class, 'index']);
    Route::post('delivery-requests-list', [DeliveryrequestController::class, 'ShowApprovalRequestlist'])->name('show-delivery-requests.index');
    Route::get('/delivery-approved-requests', [DeliveryrequestController::class, 'ApprovedRequests']);
    Route::get('/delivery-rejected-requests', [DeliveryrequestController::class, 'RejectRequests']);
    Route::get('/delivery-approve-request-view/{id}', [DeliveryrequestController::class, 'ApproveRequestsView'])->name('approve-request-view');
    Route::post('/delivery-approve-status/{id}', [DeliveryrequestController::class, 'ApproveStatus']);
    Route::post('/delivery-rejected-status/{id}', [DeliveryrequestController::class, 'RejectStatus']);

    Route::get('/deposit-pending-requests', [DepositController::class, 'index']);
    Route::post('deposit-requests-list', [DepositController::class, 'ShowApprovalRequestlist'])->name('show-deposit-requests.index');
    Route::get('/deposit-approved-requests', [DepositController::class, 'ApprovedRequests']);
    Route::get('/deposit-rejected-requests', [DepositController::class, 'RejectRequests']);
    Route::get('/deposit-approve-request-view/{id}', [DepositController::class, 'ApproveRequestsView'])->name('approve-request-view');
    Route::post('/deposit-approve-status/{id}', [DepositController::class, 'ApproveStatus']);
    Route::post('/deposit-rejected-status/{id}', [DepositController::class, 'RejectStatus']);

    Route::get('/donation', [DonationController::class, 'index']);
    Route::post('get-donation-list', [DonationController::class, 'GetDonationList'])->name('get-donation-list.donation');
    Route::post('create-donation', [DonationController::class, 'CreateDonation'])->name('create-donation.donation');
    Route::post('get-donation-data', [DonationController::class, 'GetDatasOf_A_Donation'])->name('get-donation-data.donation');
    Route::post('update-donation-data', [DonationController::class, 'UpdateTheDataOfDonation'])->name('update-donation-data.donation');
    Route::post('delete-donation-data', [DonationController::class, 'DeleteTheDonation'])->name('delete-donation-data.donation');

    Route::get('/gallery-category', [GalleryController::class, 'index']);
    Route::post('/get-gallery-category-list', [GalleryController::class, 'GetGallerCategoryList'])->name('get-gallery-category-list.gallery-category');
    Route::post('create-gallery-category', [GalleryController::class, 'CreateGallerCategory'])->name('create-gallery-category.gallery-category');
    Route::post('get-gallery-category-data', [GalleryController::class, 'GetDatasOf_A_GalleryCategory'])->name('get-gallery-category-data.gallery-category');
    Route::post('update-gallery-category-data', [GalleryController::class, 'UpdateTheDataOfGalleryCategory'])->name('update-gallery-category-data.gallery-category');
    Route::post('delete-gallery-category-data', [GalleryController::class, 'DeleteTheGalleryCategory'])->name('delete-gallery-category-data.gallery-category');
    Route::post('change-gallery-category-status', [GalleryController::class, 'ChangeStatusCategory'])->name('change-gallery-category-status.image');

    Route::get('/gallery-image', [GalleryController::class, 'ImageIndex']);
    Route::post('/get-gallery-image-list', [GalleryController::class, 'GetGallerImageList'])->name('get-gallery-image-list.gallery-image');
    Route::post('create-gallery-image', [GalleryController::class, 'CreateGallerImage'])->name('create-gallery-image.gallery-image');
    Route::post('get-gallery-image-data', [GalleryController::class, 'GetDatasOf_A_GalleryImage'])->name('get-gallery-image-data.gallery-image');
    Route::post('update-gallery-image-data', [GalleryController::class, 'UpdateTheDataOfGalleryImage'])->name('update-gallery-image-data.gallery-image');
    Route::post('delete-gallery-image-data', [GalleryController::class, 'DeleteTheGalleryImage'])->name('delete-gallery-image-data.image');
    Route::post('change-gallery-image-status', [GalleryController::class, 'ChangeStatus'])->name('change-gallery-image-status.image');

    Route::get('/special-programme/categories', [SpecialProgrammeCategoryController::class, 'index']);
    Route::post('get-special-programme-categories-list', [SpecialProgrammeCategoryController::class, 'GetSpecialCategories'])->name('get-special-programme-categories-list.sp_cat');
    Route::post('create-special-programme-category', [SpecialProgrammeCategoryController::class, 'CreateCategory'])->name('create-special-programme-category.sp_cat');
    Route::post('get-special-programme-category', [SpecialProgrammeCategoryController::class, 'GetDatasOf_A_Category'])->name('get-special-programme-category.sp_cat');
    Route::post('update-special-programme-category', [SpecialProgrammeCategoryController::class, 'UpdateTheDataOfCategory'])->name('update-special-programme-category.sp_cat');
    Route::post('update-special-programme-category-sort', [SpecialProgrammeCategoryController::class, 'UpdateTheSortOrderOfCategory'])->name('update-special-programme-category-sort.sp_cat');
    Route::post('update-special-programme-category-status', [SpecialProgrammeCategoryController::class, 'UpdateTheStatusOfCategory'])->name('update-special-programme-category-status.sp_cat');
    Route::post('delete-special-programme-category-status', [SpecialProgrammeCategoryController::class, 'DeleteTheCategory'])->name('delete-special-programme-category-status.sp_cat');

    Route::get('/special-programme/contents', [SpecialProgrammeContentController::class, 'index']);
    Route::post('get-special-programme-contents-list', [SpecialProgrammeContentController::class, 'GetData'])->name('get-special-programme-contents-list.sp_content');
    Route::post('create-special-programme-content', [SpecialProgrammeContentController::class, 'CreateContent'])->name('create-special-programme-content.sp_content');
    Route::post('get-special-programme-content', [SpecialProgrammeContentController::class, 'GetDatasOf_A_Content'])->name('get-special-programme-content.sp_content');
    Route::post('update-special-programme-content', [SpecialProgrammeContentController::class, 'UpdateTheDataOfContent'])->name('update-special-programme-content.sp_content');
    Route::post('update-special-programme-content-sort', [SpecialProgrammeContentController::class, 'UpdateTheSortOrderOfContent'])->name('update-special-programme-content-sort.sp_content');
    Route::post('update-special-programme-content-status', [SpecialProgrammeContentController::class, 'UpdateTheStatusOfContent'])->name('update-special-programme-content-status.sp_content');
    Route::post('delete-special-programme-content-status', [SpecialProgrammeContentController::class, 'DeleteTheContent'])->name('delete-special-programme-content-status.sp_content');

    Route::get('/sanchika/categories', [SanchikaCategoryController::class, 'index']);
    Route::post('get-sanchika-categories-list', [SanchikaCategoryController::class, 'GetSanchikaCategories'])->name('get-sanchika-categories-list.sanchik_cat');
    Route::post('create-sanchika-category', [SanchikaCategoryController::class, 'CreateCategory'])->name('create-sanchika-category.sanchik_cat');
    Route::post('get-sanchika-category', [SanchikaCategoryController::class, 'GetDatasOf_A_Category'])->name('get-sanchika-category.sanchik_cat');
    Route::post('update-sanchika-category', [SanchikaCategoryController::class, 'UpdateTheDataOfCategory'])->name('update-sanchika-category.sanchik_cat');
    Route::post('update-sanchika-category-sort', [SanchikaCategoryController::class, 'UpdateTheSortOrderOfCategory'])->name('update-sanchika-category-sort.sanchik_cat');
    Route::post('update-sanchika-category-status', [SanchikaCategoryController::class, 'UpdateTheStatusOfCategory'])->name('update-sanchika-category-status.sanchik_cat');
    Route::post('delete-sanchika-category-status', [SanchikaCategoryController::class, 'DeleteTheCategory'])->name('delete-sanchika-category-status.sanchik_cat');

    Route::get('/sanchika/pdfs', [SanchikaContentController::class, 'index']);
    Route::post('get-sanchik-contents-list', [SanchikaContentController::class, 'GetData'])->name('get-sanchik-contents-list.sanchik_content');
    Route::post('create-sanchik-content', [SanchikaContentController::class, 'CreateContent'])->name('create-sanchik-content.sanchik_content');
    Route::post('get-sanchik-content-data', [SanchikaContentController::class, 'GetDatasOf_A_Content'])->name('get-sanchik-content-data.sanchik_content');
    Route::post('update-sanchik-content-data', [SanchikaContentController::class, 'UpdateTheDataOfContent'])->name('update-sanchik-content-data.sanchik_content');
    Route::post('update-sanchika-content-sort', [SanchikaContentController::class, 'UpdateTheSortOrderOfContent'])->name('update-sanchika-content-sort.sanchik_content');
    Route::post('update-sanchika-content-status', [SanchikaContentController::class, 'UpdateTheStatusOfContent'])->name('update-sanchika-content-status.sanchik_content');
    Route::post('delete-sanchika-content-status', [SanchikaContentController::class, 'DeleteTheContent'])->name('delete-sanchika-content-status.sanchik_content');

    Route::get('/donation-category', [DonationCategoryController::class, 'Index']);
    Route::post('/get-donation-category-list', [DonationCategoryController::class, 'GetDonationList'])->name('get-donation-category-list.donation-category');
    Route::post('change-donation-category-status', [DonationCategoryController::class, 'ChangeStatus'])->name('change-donation-category-status.donation-category');
    Route::post('create-donation-category', [DonationCategoryController::class, 'CreateDonationCategory'])->name('create-donation-category.donation-category');
    Route::post('get-donation-category-data', [DonationCategoryController::class, 'GetDatasOf_A_DonationCategory'])->name('get-donation-category-data.donation-category');
    Route::post('update-donation-category-data', [DonationCategoryController::class, 'UpdateTheDataOfDonationCategory'])->name('update-donation-category-data.donation-category');
    Route::post('delete-donation-category-data', [DonationCategoryController::class, 'DeleteTheDonationCategory'])->name('delete-donation-category-data.donation-category');

    Route::get('kinchit-service', [kinchitServiceController::class, 'index']);
    Route::post('get-service-list', [kinchitServiceController::class, 'ShowList'])->name('get-service-list.kinchit-service');
    Route::post('create-the-service', [kinchitServiceController::class, 'CreateData'])->name('create-the-service.kinchit-service');
    Route::post('change-service-status', [kinchitServiceController::class, 'ChangeStatus'])->name('change-service-status.kinchit-service');
    Route::post('get-the-service', [kinchitServiceController::class, 'GetEditData'])->name('get-the-service.kinchit-service');
    Route::post('update-the-service', [kinchitServiceController::class, 'UpdateData'])->name('update-the-service.kinchit-service');
    Route::post('delete-service-data', [kinchitServiceController::class, 'DeleteTheData'])->name('delete-service-data.kinchit-service');
    
    Route::get('our-service', [HomePageController::class, 'index']);
    Route::post('get-our-service', [HomePageController::class, 'GetServiceContentList'])->name('get-our-service.our-service');
    Route::post('create-our-service', [HomePageController::class, 'CreateServiceArticle'])->name('create-our-service.our-service');
    Route::post('our-service-change-status', [HomePageController::class, 'ChangeServicesStatus'])->name('our-service-change-status.our-service');
    Route::post('get-our-service-data', [HomePageController::class, 'GetDatasOf_A_Service'])->name('get-our-service-data.our-service');
    Route::post('update-our-service-data', [HomePageController::class, 'UpdateTheDataOfService'])->name('update-our-service-data.our-service');
    Route::post('delete-data-our-service', [HomePageController::class, 'DeleteTheService'])->name('delete-data-our-service.our-service');

    Route::get('home-image', [HomePageController::class, 'HomeImage']);
    Route::post('get-home-image', [HomePageController::class, 'GetHomeImageList'])->name('get-home-image.home-image');
    Route::post('create-home-image', [HomePageController::class, 'CreateHomeImage'])->name('create-home-image.home-image');
    Route::post('home-image-change-status', [HomePageController::class, 'ChangeHomeImageStatus'])->name('home-image-change-status.home-image');
    Route::post('get-home-image-data', [HomePageController::class, 'GetDatasOf_A_home_image'])->name('get-home-image-data.home-image');
    Route::post('update-home-image-data', [HomePageController::class, 'UpdateTheDataOfHomeImage'])->name('update-home-image-data.home-image');
    Route::post('delete-data-home-image', [HomePageController::class, 'DeleteTheHomeImage'])->name('delete-data-home-image.home-image');

    Route::get('about-us', [HomePageController::class, 'AboutUs']);
    Route::post('get-about-us', [HomePageController::class, 'GetAboutUsList'])->name('get-about-us.about-us');
    Route::post('create-about-us', [HomePageController::class, 'CreateAboutUs'])->name('create-about-us.about-us');
    Route::post('about-us-change-status', [HomePageController::class, 'ChangeAboutUsStatus'])->name('about-us-change-status.about-us');
    Route::post('get-about-us-data', [HomePageController::class, 'GetDatasOf_A_AboutUs'])->name('get-about-us-data.about-us');
    Route::post('update-about-us-data', [HomePageController::class, 'UpdateTheDataOfAboutUs'])->name('update-about-us-data.about-us');
    Route::post('delete-data-about-us', [HomePageController::class, 'DeleteTheAboutUs'])->name('delete-data-about-us.about-us');

    Route::get('home-banner', [HomePageController::class, 'HomeBanner']);
    Route::post('get-home-banner', [HomePageController::class, 'GetHomeBannerList'])->name('get-home-banner.home-banner');
    Route::post('create-home-banner', [HomePageController::class, 'CreateHomeBanner'])->name('create-home-banner.home-banner');
    Route::post('home-banner-change-status', [HomePageController::class, 'ChangeHomeBannerStatus'])->name('home-banner-change-status.home-banner');
    Route::post('get-home-banner-data', [HomePageController::class, 'GetDatasOf_A_home_banner'])->name('get-home-banner-data.home-banner');
    Route::post('update-home-banner-data', [HomePageController::class, 'UpdateTheDataOfHomeBanner'])->name('update-home-banner-data.home-banner');
    Route::post('delete-data-home-banner', [HomePageController::class, 'DeleteTheHomeBanner'])->name('delete-data-home-banner.home-banner');
});
