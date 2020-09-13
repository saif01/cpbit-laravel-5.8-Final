<?php
//Login Route Start
Route::get('/', 'login\LoginUserController@ShowLoginForm' )->name('user.login.form');
Route::get('/admin', 'login\LoginAdminController@ShowLoginForm')->name('admin.login.form');
//Local Login



// // //AD Login
// Route::post('/user-login', 'login\LoginUserController@loginActionAD')->name('user.login.action');
// Route::post('/admin-login', 'login\LoginAdminController@loginActionAD')->name('admin.login.action');


//Local Login
Route::post('/admin-login', 'login\LoginAdminController@loginAction')->name('admin.login.action');
Route::post('/user-login', 'login\LoginUserController@loginAction')->name('user.login.action');


//Login Route End





//Error Page Start
Route::view('/admin-error', 'admin.layout.error')->name('admin.error');
Route::view('/user-error', 'user.layout.error')->name('user.error');
//Error Page End

Route::get('/hard-subcategory', 'userController\UserCmsController@HardSubcategory')->name('user.hard.subcategory');


//Start All User Routes
Route::group(['middleware' => ['userLogin'], 'prefix' => 'user'], function () {

    Route::get('/dashboard', 'login\LoginUserController@Dashboard')->name('user.dashboard');
    Route::get('/logout', 'login\LoginUserController@Logout')->name('user.logout');




    //Carpool User Start
    Route::group(['middleware' => ['userRollMid:car', 'revalidate'], 'prefix' => 'car'], function () {
        Route::get('/dashboard', 'userController\UserCarPoolController@Dashboard')->name('user.carpool.dashboard');
        //Car List
        Route::get('/regular-car-list', 'userController\UserCarPoolController@RegularCars')->name('regular.car.list');
        Route::get('/temporary-car-list', 'userController\UserCarPoolController@TemporaryCars')->name('temporary.car.list');

        //Booking
        Route::get('/regular-car-booking/{carId}', 'userController\UserCarPoolController@RegularCarBooking')->name('regular.car.booking');
        Route::get('/temporary-car-booking/{carId}', 'userController\UserCarPoolController@TemporaryCarBooking')->name('temporary.car.booking');
        Route::get('/cancel-booked-car/{id}', 'CarBookingController@UserCancelCar')->name('user.cancel.car');
        Route::post('/car-booking-modify-action', 'CarBookingController@UserCarBookingModifyAction')->name('user.car.booking.modify.action');
         Route::get('/modify-booked-car-data', 'userController\UserCarPoolController@ModifyBookedData')->name('user.modify.booked.data');

        //Booking Action
        Route::post('/regular-car-booking-action/{carId}/{number}/{driverId}/{drivName}/{contact}', 'CarBookingController@RegularCarBookingAction')->name('regular.car.booking.action');
        Route::post('/temporary-car-booking-action/{carId}/{number}/{driverId}/{drivName}/{contact}', 'CarBookingController@TemporaryCarBookingAction')->name('temporary.car.booking.action');
        //After Booking
        Route::get('/my-booked-car', 'userController\UserCarPoolController@UserBookedCar')->name('user.booked.car');

        Route::get('/single-booked-car-data', 'userController\UserCarPoolController@BookedCarData')->name('user.booked.car.data');
        Route::post('/car-comment-action','userController\UserCarPoolController@UserCarCommentAction')->name('user.car.comment.action');

        Route::get('/my-not-commented-car', 'userController\UserCarPoolController@UserNotCommentedCar')->name('user.notcommented.car');

        Route::get('/canceled-booked-car', 'userController\UserCarPoolController@UserCanceledBookingCar')->name('user.canceled.booking.car');
        Route::get('/user-profile', 'userController\UserCarPoolController@UserProfile')->name('user.profile');
        Route::get('/booking-history', 'userController\UserCarPoolController@UserBookingHistory')->name('user.booking.history');
        Route::get('/driver-profile/{id}', 'userController\UserCarPoolController@DriverProfile')->name('driver.profile');
        Route::get('/car-details/{id}', 'userController\UserCarPoolController@CarDetails')->name('user.car.details');


    });
    //Carpool User End




    //Room User Start
    Route::group(['middleware' => ['userRollMid:room', 'revalidate'], 'prefix' => 'room'], function () {
        Route::get('/', 'userController\UserRoomController@Index')->name('user.room.dashboard');
        Route::get('/meeting-room', 'userController\UserRoomController@MeetingRoomList')->name('user.meeting.room.list');
        Route::get('/meeting-room-booking/{id}', 'userController\UserRoomController@MeetingRoomBooking')->name('user.meeting.room.booking');

        Route::post('/meeting-room-booking-action/{id}/{roomName}', 'userController\UserRoomController@MeetingRoomBookingAction')->name('user.meeting.room.booking.action');

        Route::get('/user-profile', 'userController\UserRoomController@UserProfile')->name('room.user.profile');
        Route::get('/user-booking-history', 'userController\UserRoomController@UserBookingHistory')->name('user.room.booking.history');
        Route::get('/user-booked-room', 'userController\UserRoomController@UserBookedRoom')->name('user.booked.room');
        Route::get('/cancel-booked-room/{id}', 'userController\UserRoomController@UserCancelRoom')->name('user.cancel.room');
        Route::post('/booking-modify-action', 'userController\UserRoomController@UserRoomBookingModifyAction')->name('user.room.booking.modify.action');
        Route::get('/canceled-booked-room', 'userController\UserRoomController@UserCanceledBookingRoom')->name('user.canceled.booked.room');
        Route::get('/details/{id}', 'userController\UserRoomController@RoomDetails')->name('user.room.details');
    });
    //Room User Start




    //CMS User Start
    Route::group([ 'middleware' => ['userRollMid:cms', 'revalidate'], 'prefix' => 'ihelpdesk'], function () {
        //Application
        Route::get('/', 'userController\UserCmsController@Index')->name('user.cms.dashboard');
        Route::get('/my-profile', 'userController\UserCmsController@UserProfile')->name('user.cms.profile');
        Route::post('/app-complain-submit', 'userController\UserCmsController@AppComplainSubmit')->name('user.app.complain.submit');
        Route::get('/app-complain-history', 'userController\UserCmsController@AppComplainHistory')->name('user.app.complain.history');
        Route::get('/app-complain-remarks', 'userController\UserCmsController@AppComplainRemarks')->name('user.app.complain.remarks');
        Route::get('/app-complain-cancel/{id}', 'userController\UserCmsController@AppComplainCancel')->name('user.app.complain.cancel');
        //SubCategory Find
        Route::get('/app-subcategory', 'userController\UserCmsController@AppSubcategory')->name('user.app.subcategory');

        //Harware
        Route::post('/hard-complain-submit', 'userController\UserCmsController@HardComplainSubmit')->name('user.hard.complain.submit');
        Route::get('/hard-complain-history', 'userController\UserCmsController@HardComplainHistory')->name('user.hard.complain.history');
        Route::get('/hard-complain-remarks', 'userController\UserCmsController@HardComplainRemarks')->name('user.hard.complain.remarks');
        Route::get('/hard-complain-cancel/{id}', 'userController\UserCmsController@HardComplainCancel')->name('user.hard.complain.cancel');


    });
    //CMS User Start




    //Start IT-Connect
    Route::group(['middleware' => ['userRollMid:it_connect','revalidate'], 'prefix'=>'iservice' ], function () {

        // Route::resource('dashboard', 'userController\ItConnectController');
        Route::get('/index', 'userController\ItConnectController@Index')->name('user.it.connect.index');
        Route::get('/report-generation', 'userController\ItConnectController@ReportGeneration')->name('user.it.connect.report.generation');
        Route::post('/reports', 'userController\ItConnectController@SmsReport')->name('user.it.connect.report');

        //Report Export In Execl
        Route::get('/export-excel-sale-order', 'ExportController\ExportController@ExportExcelSaleOrder' )->name('user.it.connect.export.excel.sale.order');
        Route::get('/export-excel-sale-payment', 'ExportController\ExportController@ExportExcelSalePayment' )->name('user.it.connect.export.excel.sale.payment');

    });
    //End IT-Connect

    //Start CoronaDesk
    Route::group(['middleware' => ['userRollMid:corona','revalidate'], 'prefix'=>'iTemp' ], function () {

        Route::get('/deshboard', 'userController\CoronaController@Dashboard')->name('user.corona.dashboard');
        Route::get('/all-user', 'userController\CoronaController@AllUser')->name('user.corona.all');
        Route::post('/store-temp', 'userController\CoronaController@StoreTemp');
        Route::get('/all-records', 'userController\CoronaController@AllRecords')->name('user.corona.all.records');
        Route::get('/all-reports', 'userController\CoronaController@AllReports')->name('user.corona.all.reports');
        Route::post('/search-data', 'userController\CoronaController@SearchData')->name('user.corona.search.data');

        Route::get('/others', 'userController\CoronaController@Others')->name('user.corona.others');
        Route::post('/others-add', 'userController\CoronaController@OthersAdd');
        Route::post('/others-search', 'userController\CoronaController@OthersSearch')->name('user.corona.others.search');


        Route::get('/test', 'userController\CoronaController@Test');


    });
    //End CoronaDesk


});
//End All User Routes





















//Start All Admin Route
Route::group(['middleware' => ['adminLogin'], 'prefix' => 'admin'], function () {

    Route::get('/dashboard', 'login\LoginAdminController@Dashboard')->name('admin.dashboard');
    Route::get('/logout', 'login\LoginAdminController@Logout')->name('admin.logout');

    //Check Unique Value
    Route::post('/check', 'CommonController@CkeckValue')->name('value_available.check');
    Route::post('/value-edit', 'CommonController@EditDataFind')->name('edit.value');
    Route::get('/change-status/{id}/{table}/{filed}/{value}', 'CommonController@ChangeStatus')->name('change.status');

    Route::get('/user-details', 'UserController@Details')->name('user.details');
    Route::get('/admin-details', 'AdminController@Details')->name('admin.details');

    //Start super admin
   Route::group(['middleware' => ['adminRollMid:super', 'revalidate'], 'prefix' => 'super'], function () {

        Route::get('/', 'AdminController@Index')->name('super.dashboard');
        //Admin
        Route::group(['middleware' => ['adminRollMid:admin_cr'], 'prefix' => 'admin_cr'], function () {
            Route::get('/all', 'AdminController@All')->name('admin.all');
            Route::get('/add', 'AdminController@Add')->name('admin.add');
            Route::post('/add-action', 'AdminController@Insert')->name('admin.add.action');
            Route::get('/edit/{id}', 'AdminController@editFormShow')->name('admin.edit');
            Route::post('/update/{id}', 'AdminController@Update')->name('admin.update.action');
            Route::get('/delete/{id}', 'AdminController@Delete')->name('admin.delete');
        });

        //User
        Route::group(['middleware' => ['adminRollMid:user_cr'], 'prefix' => 'user_cr'] , function () {
            Route::get('/all', 'UserController@All')->name('user.all');
            Route::get('/add', 'UserController@Add')->name('user.add');
            Route::post('/add-action', 'UserController@Insert')->name('user.add.action');
            Route::get('/edit/{id}', 'UserController@EditFormShow')->name('user.edit');
            Route::post('/update/{id}', 'UserController@Update')->name('user.update.action');
            Route::get('/delete/{id}', 'UserController@Delete')->name('user.delete');
        });

        //Departments
        Route::group(['prefix' => 'department'], function () {
            Route::get('/all', 'DepartmentContrpller@All')->name('department.all');
            Route::get('/delete/{id}', 'DepartmentContrpller@Delete')->name('department.delete');
            Route::post('/add-action', 'DepartmentContrpller@Insert')->name('department.add.action');
            Route::post('/update-action', 'DepartmentContrpller@Update')->name('department.update.action');
        });

        //Destination
        Route::group(['prefix' => 'destination'], function () {
            Route::get('/all', 'DestinationController@All')->name('destination.all');
            Route::get('/delete/{id}', 'DestinationController@Delete')->name('destination.delete');
            Route::post('/add-action', 'DestinationController@Insert')->name('destination.add.action');
            Route::post('/update-action', 'DestinationController@Update')->name('destination.update.action');
        });

        //B. U. Locations
        Route::group(['prefix' => 'business-unit-location'], function () {
            Route::get('/all', 'BuLocationController@All')->name('bulocation.all');
            Route::get('/delete/{id}', 'BuLocationController@Delete')->name('bulocation.delete');
            Route::post('/add-action', 'BuLocationController@Insert')->name('bulocation.add.action');
            Route::post('/update-action', 'BuLocationController@Update')->name('bulocation.update.action');
        });

        //Top Bar Address
        Route::group(['prefix' => 'top-bar'], function () {
            Route::get('/all', 'TopbarController@All')->name('topbar.all');
            Route::get('/delete/{id}', 'TopbarController@Delete')->name('topbar.delete');
            Route::post('/add-action', 'TopbarController@Insert')->name('topbar.add.action');
            Route::post('/update-action', 'TopbarController@Update')->name('topbar.update.action');
        });

        Route::get('/user-activity', 'UserController@UserActivity')->name('user.activity');
        Route::get('/user-activity-loginlog','UserController@UserActivityLoginlog')->name('user.activity.loginlog');

        // Route::group(['prefix' => 'reports'], function () {
        //     Route::get('/carpool-all', 'CarReportsController@ReportsAllForSuper')->name('super.carpool.reports.all');
        //     Route::post('/single-car', 'CarReportsController@ReportBySearchForSuper')->name('super.carpool.report.search');
        // });

        //Login Log
        Route::group(['prefix' => 'loginlog'], function () {
            Route::get('/user', 'AdminController@UserLoginLog')->name('super.user.login.log');
            Route::get('/user-error', 'AdminController@UserLoginError')->name('super.user.login.error');
            Route::get('/admin', 'AdminController@AdminLoginLog')->name('super.admin.login.log');
            Route::get('/admin-error', 'AdminController@AdminLoginError')->name('super.admin.login.error');
        });

        //Maintenance
        Route::group(['prefix' => 'maintanance'], function () {
            Route::get('/check', 'AdminController@Maintenance')->name('super.maintanance');
            Route::get('/active', 'AdminController@MaintenanceActive')->name('super.maintanance.active');
            Route::get('/deactive', 'AdminController@MaintenanceDeactive')->name('super.maintanance.deactive');
        });

        //SMS Send
        Route::group(['prefix' => 'sms'], function () {

            Route::get('/sms-user', 'SmsUserController@Index')->name('sms.user.super');
            Route::get('/sms-user-access/{id}', 'SmsUserController@UserAccess')->name('sms.user.access.super');
            Route::post('/sms-user-update', 'SmsUserController@SmsUserUpdate')->name('sms.user.super.update');

        });


        //IT-Connect For Super Admin
        Route::group(['prefix' => 'iservice'], function () {

            Route::group(['prefix' => 'operation'], function () {
                Route::get('/all', 'ItConnect\ItConnectOperationSuperController@All')->name('it.connect.super.operation.all');
                Route::get('/delete/{id}', 'ItConnect\ItConnectOperationSuperController@Delete')->name('it.connect.super.operation.delete');
                Route::post('/add-action', 'ItConnect\ItConnectOperationSuperController@Insert')->name('it.connect.super.operation.add.action');
                Route::post('/update-action', 'ItConnect\ItConnectOperationSuperController@Update')->name('it.connect.super.operation.update.action');
            });

            Route::get('/sms-user', 'SmsUserController@Index')->name('sms.user.super');
            Route::get('/sms-user-access/{id}', 'SmsUserController@UserAccess')->name('sms.user.access.super');
            Route::post('/sms-user-update', 'SmsUserController@SmsUserUpdate')->name('sms.user.super.update');

        });


   });
    //End super admin





    //IT-Connect Admin
    Route::group(['middleware' => ['adminRollMid:it_connect', 'revalidate'], 'prefix' =>'iservice'], function () {

        Route::get('/dashboard', 'ItConnect\ItConnectController@Index')->name('it.connect.dashboard');

        Route::get('/report-generate', 'ItConnect\ItConnectController@ReportGenerate')->name('it.connect.admin.report.generate');

        //Report View
        Route::post('/reports-view', 'ItConnect\ItConnectController@SmsReport')->name('it.connect.admin.view.report');

        //Report Export In Execl
        Route::get('/export-excel-sale-order', 'ExportController\ExportController@ExportExcelSaleOrder' )->name('it.connect.export.excel.sale.order');
        Route::get('/export-excel-sale-payment', 'ExportController\ExportController@ExportExcelSalePayment' )->name('it.connect.export.excel.sale.payment');


        //It-Connect Operations
        Route::group(['prefix' => 'operation'], function () {
            Route::get('/all', 'ItConnect\ItConnectOperartionController@All')->name('it.connect.admin.operation.all');
            Route::get('/delete/{id}', 'ItConnect\ItConnectOperartionController@Delete')->name('it.connect.admin.operation.delete');
            Route::post('/add-action', 'ItConnect\ItConnectOperartionController@Insert')->name('it.connect.admin.operation.add.action');
            Route::post('/update-action', 'ItConnect\ItConnectOperartionController@Update')->name('it.connect.admin.operation.update.action');
        });

    });
    //IT-Connect Admin




    //Start Carpool Admin
    Route::group(['middleware' => ['adminRollMid:car', 'revalidate'], 'prefix' =>'carpool'], function () {

        Route::get('/', 'CarController@Index')->name('carpool.admin.dashboard');

            //Car
            Route::group(['prefix' => 'car'], function () {
                    Route::get('/all', 'CarController@All')->name('car.all');
                    Route::get('/add', 'CarController@Add')->name('car.add');
                    Route::post('/add-action', 'CarController@Insert')->name('car.add.action');
                    Route::post('/car-deadline-fix', 'CarController@DeadlineFix')->name('car.deadline.fix');
                    Route::get('/car-deadline-clear/{id}', 'CarController@DeadlineClear')->name('car.deadline.clear');
                    Route::get('/edit/{id}', 'CarController@EditFormShow')->name('car.edit');
                    Route::post('/update/{id}', 'CarController@Update')->name('car.update.action');
                    Route::get('/delete/{id}', 'CarController@Delete')->name('car.delete');
                    Route::get('/car-details', 'CarController@Details')->name('car.details');
            });

            //Driver
            Route::group(['prefix' => 'driver'], function () {
                Route::get('/all', 'DriverController@All')->name('driver.all');
                Route::get('/add', 'DriverController@Add')->name('driver.add');
                Route::post('/add-action', 'DriverController@Insert')->name('driver.add.action');
                Route::get('/edit/{id}', 'DriverController@EditFormShow')->name('driver.edit');
                Route::post('/update/{id}', 'DriverController@Update')->name('driver.update.action');
                Route::get('/delete/{id}', 'DriverController@Delete')->name('driver.delete');
                Route::post('/update/{id}', 'DriverController@Update')->name('driver.update.action');

                Route::post('/action-modal', 'DriverController@ModalAction')->name('driver.modal.action');
                Route::get('/driver-details', 'DriverController@Details')->name('driver.details');
            });

            //Reports
            Route::group(['prefix' => 'reports'], function () {
                Route::get('/all', 'CarReportsController@All')->name('car.reports.all');

            });

            //Reports
            Route::group(['prefix' => 'reports'], function () {
                Route::get('/calendar', 'CarReportsController@ReportsCalendar')->name('car.report.calendar');
                Route::post('/calendar-search', 'CarReportsController@ReportsCalendarForSearch')->name('car.report.calendar.search');

                Route::get('/all', 'CarReportsController@ReportsAll')->name('car.report.all');
                Route::post('/single-car', 'CarReportsController@ReportBySearch')->name('car.report.search');

                Route::get('/maintenance', 'CarReportsController@MaintenanceReport')->name('car.maintenance.report');
                Route::get('/driver-leave', 'CarReportsController@DriverLeaveReport')->name('driver.leave.report');
                Route::get('/car-requisition', 'CarReportsController@CarRequisitionReport')->name('car.requisition.report');
            });


             //Destination
            Route::group(['prefix' => 'destination'], function () {
                Route::get('/all', 'DestinationController@AllForCar')->name('car.destination.all');
                Route::get('/delete/{id}', 'DestinationController@DeleteForCar')->name('car.destination.delete');
                Route::post('/add-action', 'DestinationController@InsertForCar')->name('car.destination.add.action');
                Route::post('/update-action', 'DestinationController@UpdateForCar')->name('car.destination.update.action');
            });


    });
    //End Carpool Admin






    //Start Room Admin
    Route::group(['middleware' => ['adminRollMid:room', 'revalidate'], 'prefix' => 'room'], function () {
        Route::get('/', 'RoomController@Index')->name('room.admin.dashboard');

            //Room
            Route::group(['prefix' => 'room'], function () {
                Route::get('/all', 'RoomController@All')->name('room.all');
                Route::get('/add', 'RoomController@Add')->name('room.add');
                Route::post('/add-action', 'RoomController@Insert')->name('room.add.action');
                Route::get('/edit/{id}', 'RoomController@EditFormShow')->name('room.edit');
                Route::post('/update/{id}', 'RoomController@Update')->name('room.update.action');
                Route::get('/delete/{id}', 'RoomController@Delete')->name('room.delete');
                Route::get('/details', 'RoomController@Details')->name('room.details');
            });

        //Reports
        Route::group(['prefix' => 'reports'], function () {
            Route::get('/calendar', 'RoomController@ReportsCalendar')->name('room.report.calendar');
            Route::post('/calendar-search', 'RoomController@ReportsCalendarForSearch')->name('room.report.calendar.search');

            Route::get('/all', 'RoomController@ReportsAll')->name('room.report.all');
            Route::post('/search', 'RoomController@ReportBySearch')->name('room.report.search');
        });


    });
    //End Room Admin





    //Start Application Admin
    Route::group(['middleware' => ['adminRollMid:app', 'revalidate'], 'prefix' => 'application'], function () {
        Route::get('/', 'ApplicationController@Index')->name('app.admin.dashboard');

        Route::group(['prefix' => 'category'], function () {
            Route::get('/all', 'AppCategorySubCategoryController@AllCategory')->name('all.app.category');
            Route::get('/delete/{id}', 'AppCategorySubCategoryController@Delete')->name('app.category.delete');
            Route::post('/add-action', 'AppCategorySubCategoryController@Insert')->name('app.category.add.action');
            Route::post('/update-action', 'AppCategorySubCategoryController@Update')->name('app.category.update.action');
        });

        Route::group(['prefix' => 'subcategory'], function () {
            Route::get('/all', 'AppCategorySubCategoryController@AllSubCategory')->name('all.app.subcategory');
            Route::get('/delete/{id}', 'AppCategorySubCategoryController@DeleteSubcategory')->name('app.subcategory.delete');
            Route::post('/add-action', 'AppCategorySubCategoryController@InsertSubcategory')->name('app.subcategory.add.action');
            Route::post('/update-action', 'AppCategorySubCategoryController@UpdateSubcategory')->name('app.subcategory.update.action');
        });

        Route::get('/not-process', 'ApplicationController@NotProcess')->name('app.notprocess.complain');
        Route::get('/processing', 'ApplicationController@Processing')->name('app.processing.complain');
        Route::get('/closed', 'ApplicationController@Closed')->name('app.closed.complain');
        Route::get('/all-reports', 'ApplicationController@AllReports')->name('app.complain.report.all');
        Route::get('/action/{id}', 'ApplicationController@Action')->name('app.complain.action');
        Route::post('/action-update/{id}/{user_id}', 'ApplicationController@ActionUpdate')->name('app.complain.action.update');


    });
    //End Application Admin





    //Start Hardware Admin
    Route::group(['middleware' => ['adminRollMid:hard', 'revalidate'], 'prefix' => 'hardware'], function () {
        Route::get('/', 'HardwareController@Index')->name('hard.admin.dashboard');

        Route::group(['prefix' => 'category'], function () {
            Route::get('/all', 'HardCategorySubcategoryController@AllCategory')->name('all.hard.category');
            Route::get('/delete/{id}', 'HardCategorySubcategoryController@Delete')->name('hard.category.delete');
            Route::post('/add-action', 'HardCategorySubcategoryController@Insert')->name('hard.category.add.action');
            Route::post('/update-action', 'HardCategorySubcategoryController@Update')->name('hard.category.update.action');
        });

        Route::group(['prefix' => 'subcategory'], function () {
            Route::get('/all', 'HardCategorySubcategoryController@AllSubCategory')->name('all.hard.subcategory');
            Route::get('/delete/{id}', 'HardCategorySubcategoryController@DeleteSubcategory')->name('hard.subcategory.delete');
            Route::post('/add-action', 'HardCategorySubcategoryController@InsertSubcategory')->name('hard.subcategory.add.action');
            Route::post('/update-action', 'HardCategorySubcategoryController@UpdateSubcategory')->name('hard.subcategory.update.action');
        });

        Route::get('/not-process', 'HardwareController@NotProcess')->name('hard.notprocess.complain');
        Route::get('/processing', 'HardwareController@Processing')->name('hard.processing.complain');
        Route::get('/closed', 'HardwareController@Closed')->name('hard.closed.complain');
        Route::get('/canceled', 'HardwareController@Canceled')->name('hard.canceled.complain');
        Route::get('/damaged', 'HardwareController@Damaged')->name('hard.damaged.complain');
        Route::get('/action/{id}', 'HardwareController@Action')->name('hard.complain.action');

        Route::group(['prefix' => 'reports'], function () {
            Route::get('/all', 'HardwareController@AllReports')->name('hard.complain.report.all');
            Route::get('/all-deliverable', 'HardwareController@AllDeliverable')->name('hard.complain.report.deliverable');
            Route::get('/all-delivered', 'HardwareController@AllDelivered')->name('hard.complain.report.delivered');
        });



        Route::post('/action-not-process/{id}/{user_id}', 'HardwareController@ActionNotProcess')->name('hard.complain.action.notprocess');
        Route::post('/action-processing/{id}/{user_id}', 'HardwareController@ActionProcessing')->name('hard.complain.action.processing');
        Route::post('/action-warranty/{id}/{user_id}', 'HardwareController@ActionWarranty')->name('hard.complain.action.warranty');
        Route::post('/action-delievery/{id}/{user_id}', 'HardwareController@ActionDelivery')->name('hard.complain.action.delievery');

    });
    //End Hardware Admin






    //Start Inventory Admin
    Route::group(['middleware' => ['adminRollMid:inventory', 'revalidate'], 'prefix' => 'inventory'], function () {
        Route::get('/', 'InventoryController@Index')->name('inv.admin.dashboard');

        Route::get('/add-new', 'InventoryController@AddNew')->name('inv.add.new');
        Route::get('/add-new-edit/{id}', 'InventoryController@AddNewEdit')->name('inv.add.new.edit');
        Route::post('/add-new-action', 'InventoryController@AddNewAction')->name('inv.add.new.action');
        Route::post('/add-edit-action/{id}', 'InventoryController@AddEditAction')->name('inv.add.edit.action');
        Route::group(['middleware' => ['adminSuper']], function () {
             Route::get('/new-delete/{id}', 'InventoryController@NewDelete')->name('inv.new.delete');
        });


        Route::get('/all-new', 'InventoryController@AllNew')->name('inv.all.new');
        Route::get('/single-new-product', 'InventoryController@SingleNewProduct')->name('inv.single.new.product');
        Route::post('/give-new-action', 'InventoryController@GiveNewAction')->name('inv.give.new.action');
        Route::get('/all-given', 'InventoryController@AllGiven')->name('inv.all.given');
        Route::get('/all-warranty', 'InventoryController@AllWarranty')->name('inv.all.warranty');
        Route::get('/all-warranty-available', 'InventoryController@AllWarrantyAvailable')->name('inv.all.warranty.available');
        Route::get('/all-warranty-expired', 'InventoryController@AllWarrantyExpired')->name('inv.all.warranty.expired');
        Route::get('/given-details', 'InventoryController@GivenDetails')->name('inv.given.details');

        Route::get('/add-old', 'InventoryController@AddOld')->name('inv.add.old');
        Route::post('/add-old-action', 'InventoryController@AddOldAction')->name('inv.add.old.action');
        Route::get('/edit-old/{id}', 'InventoryController@EditOld')->name('inv.eidt.old');
        Route::post('/edit-old-action/{id}', 'InventoryController@EditOldAction')->name('inv.edit.old.action');
        Route::get('/all-old', 'InventoryController@AllOld')->name('inv.all.old');
        Route::get('/all-old-running', 'InventoryController@AllOldRunning')->name('inv.all.old.running');
        Route::get('/all-old-damaged', 'InventoryController@AllOldDamaged')->name('inv.all.old.damaged');
        Route::get('/details', 'InventoryController@DetailsOld')->name('inv.old.details');
        Route::post('/old-search-action', 'InventoryController@OldSearchAction')->name('inv.old.search.action');

         //Operation
         Route::group(['prefix' => 'operation'], function () {
            Route::get('/all', 'OperationController@All')->name('operation.all');
            Route::get('/delete/{id}', 'OperationController@Delete')->name('operation.delete');
            Route::post('/add-action', 'OperationController@Insert')->name('operation.add.action');
            Route::post('/update-action', 'OperationController@Update')->name('operation.update.action');
        });

        Route::get('/operation-list', 'InventoryController@OperationList')->name('operation.list');
        Route::get('/operation-report/{op}', 'InventoryController@OperationReport')->name('operation.report');

    });
    //End Hardware Admin





    //Start Network
    Route::group(['middleware' => ['adminRollMid:network'],'prefix' => 'network'], function () {
        Route::get('/dashboard', 'Network\NetworkController@Index')->name('network.dashboard');


         //Main IP
         Route::group(['prefix' => 'main-ip'], function () {
            Route::get('/all', 'Network\NetworkMainIpController@All')->name('main.ip.all');
            Route::get('/delete/{id}', 'Network\NetworkMainIpController@Delete')->name('main.ip.delete');
            Route::post('/add-action', 'Network\NetworkMainIpController@Insert')->name('main.ip.add.action');
            Route::post('/update-action', 'Network\NetworkMainIpController@Update')->name('main.ip.update.action');
        });

         //Sub IP
         Route::group(['prefix' => 'sub-ip'], function () {
            Route::get('/all', 'Network\NetworkSubIpController@All')->name('sub.ip.all');
            Route::get('/delete/{id}', 'Network\NetworkSubIpController@Delete')->name('sub.ip.delete');
            Route::post('/add-action', 'Network\NetworkSubIpController@Insert')->name('sub.ip.add.action');
            Route::post('/update-action', 'Network\NetworkSubIpController@Update')->name('sub.ip.update.action');
        });

         //Group Name
         Route::group(['prefix' => 'group'], function () {
            Route::get('/all', 'Network\NetworkGroupController@All')->name('network.group.all');
            Route::get('/delete/{id}', 'Network\NetworkGroupController@Delete')->name('network.group.delete');
            Route::post('/add-action', 'Network\NetworkGroupController@Insert')->name('network.group.add.action');
            Route::post('/update-action', 'Network\NetworkGroupController@Update')->name('network.group.update.action');
        });


        //All Group IP Report
        Route::group(['prefix' => 'group'], function () {

            Route::get('/list/{group_name}', 'Network\NetworkGroupController@ByGroupSubIpList')->name('group.ip.list');



            //Sub IP Reports
            Route::post('/ping-search-report', 'Network\NetworkSubIpPingController@GroupIpSearchPingReport')->name('group.ip.ping.search.report');
            Route::get('/ping-offline-report/{group_name}', 'Network\NetworkSubIpPingController@GroupIpPingOfflineReport')->name('group.ip.ping.offline.report');

            // Sub Ip Ping
            Route::get('/single-ip-report', 'Network\NetworkSubIpPingController@SingleIpPingReport')->name('single.ip.report');
            Route::get('/single-ip-ping/{ip}', 'Network\NetworkSubIpPingController@SingleIpPing')->name('single.ip.ping');
            Route::post('/ping/{group_name}', 'Network\NetworkSubIpPingController@GroupSubIpPing')->name('group.ip.ping');

        });

          //All Main IP Report
          Route::group(['prefix' => 'report'], function () {
            Route::get('/main-ip', 'Network\NetworkMainIpPingController@ReportMainIp')->name('report.main.ip');
            Route::post('/main-ip-search', 'Network\NetworkMainIpPingController@ReportMainIpSearch')->name('report.main.ip.search');
        });

        Route::get('/main-ip-ping', 'Network\NetworkMainIpPingController@AllMainIpPingByBrowser')->name('network.main.ip.ping');
        Route::get('/pingmsg', 'NetworkController@pingMsg');


    });

    //end Network Admin


    //Start corona-desk Admin
    Route::group(['middleware' => ['adminRollMid:corona', 'revalidate'], 'prefix' => 'iTemp'], function () {
        Route::get('/', 'Corona\CoronaController@Dashboard')->name('corona.dashboard');

         //Business Unit
         Route::group([ 'prefix' => 'all-user'], function () {
            Route::get('/dashboard', 'Corona\CoronaUserController@Dashboard')->name('corona.user.dashboard');
            Route::post('/store', 'Corona\CoronaUserController@DataStore')->name('corona.user.store');
            Route::get('/data-edit/{id}', 'Corona\CoronaUserController@DataEdit');
            Route::post('/data-update', 'Corona\CoronaUserController@DataUpdate');
            Route::get('/data-delete/{id}', 'Corona\CoronaUserController@DataDelete');
            Route::get('/status/{id}/{val}', 'Corona\CoronaUserController@Status');

        });

        //checkpoint
        Route::group([ 'prefix' => 'checkpoint'], function () {
            Route::get('/dashboard', 'Corona\CheckpointController@Dashboard')->name('admin.corona.checkpoint');
            Route::post('/store', 'Corona\CheckpointController@DataStore');
            Route::get('/data-edit/{id}', 'Corona\CheckpointController@DataEdit');
            Route::post('/data-update', 'Corona\CheckpointController@DataUpdate');
            Route::get('/data-delete/{id}', 'Corona\CheckpointController@DataDelete');

        });

         //checkpoint
         Route::group([ 'prefix' => 'reports'], function () {
            Route::get('/user-temp', 'Corona\UserReportController@UserTempReports')->name('admin.user.temp.reports');
            Route::post('/user-temp-search', 'Corona\UserReportController@UserTempSearch')->name('admin.user.temp.search');
            Route::get('/single-details/{id}', 'Corona\UserReportController@SingleDetails');

            Route::get('/others-temp', 'Corona\OtherReportController@OthersTempReports')->name('admin.others.temp.reports');
            Route::post('/others-temp-search', 'Corona\OtherReportController@OthersTempSearch')->name('admin.others.temp.search');

        });





    });
    //End corona-desk Admin

});
//End All Admin Route




Route::get('/sms', 'TestController@SmsSend');
Route::get('/excel', 'SmsDataController@export')->name('excel.report.test');


Route::get('/clear', function() {
   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
   return "Cleared!";
});

Route::get('/today-car-msg', function(){
    Artisan::call('carpool:today');
    return "Carpool Today Booked Message Send To Line Groupe";

});


Route::get('/today-room-msg', function(){
    Artisan::call('room:today');
    return "Room Booked Today Booking Message Send To Line Groupe";

});

Route::get('/ping', function(){
    Artisan::call('mainIp:ping');
    return "Main IP Ping Message Send To Line Groupe";

});



//For test Routes
// Route::view('/test', 'admin.super.index');

Route::group(['middleware' => 'rollCheck:sms'], function () {

    Route::get('/test', 'TestController@Test');

});

Route::group(['middleware' =>['testMid:sms,Addd'] ], function () {

    Route::get('/test2', 'TestController@Test');

});






Route::post('/testCheckBox', 'TestController@CheckBox')->name('test.checkbox');

Route::get('/sms-send', 'TestController@SmsSend');

Route::get('/test-ip', 'TestController@TesstIP');


// Route::post('/mail', 'TestController@Mail')->name('test.mail');
// Route::view('mail-form', 'test');

// Route::post('/mail-action', 'TestController@MailAction')->name('send.mail.action');
// Route::view('/mini', 'test');
