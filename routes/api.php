<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\EnfantController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
    Route::post("/login-admin",[AdminController::class,'login']);
    Route::post("/login-enseignant",[EnseignantController::class,'login']);
    Route::post("/login-parent",[ParentController::class,'login']);
    
    Route::middleware(['auth:admins','checkrole:SuperAdmin,Admin'])->group(function () { 
        
        
        // getion de parent
        Route::get('/parents/{id}',[ParentController::class, 'show']);
        Route::get('/parents',[ParentController::class, 'index']);
        Route::post('/addparent',[ParentController::class,'store']);
        Route::put('/updateparent/{id}',[ParentController::class,'update']);
        Route::delete('/removeparent/{id}', [ParentController::class,'destroy']);
        
        // getion de class
        Route::get('/classes/{id}',[ClassController::class, 'show']);
        Route::get('/classes',[ClassController::class, 'index']);
        Route::post('/addclass',[ClassController::class,'store']);
        Route::put('/updateclass/{id}',[ClassController::class,'update']);
        Route::delete('/removeclass/{id}', [ClassController::class,'destroy']);
        
        // getion de matiere
        Route::get('/matieres/{id}',[MatiereController::class, 'show']);
        Route::get('/matieres',[MatiereController::class, 'index']);
        Route::post('/addmatiere',[MatiereController::class,'store']);
        Route::put('/updatematiere/{id}',[MatiereController::class,'update']);
        Route::delete('/removematiere/{id}', [MatiereController::class,'destroy']);
        
        // getion de enfant
        Route::get('/enfants/{id}',[EnfantController::class, 'show']);
        Route::get('/enfants',[EnfantController::class, 'index']);
        Route::post('/addenfant',[EnfantController::class,'store']);
        Route::put('/updateenfant/{id}',[EnfantController::class,'update']);
        Route::delete('/removeenfant/{id}', [EnfantController::class,'destroy']);

        // getion de reclamation
        Route::get('/reclamations/{id}',[ReclamationController::class, 'show']);
        Route::get('/reclamations',[ReclamationController::class, 'index']);
        
        // getion de enseignant
        Route::get('/enseignants/{id}',[EnseignantController::class, 'show']);
        Route::get('/enseignants',[EnseignantController::class, 'index']);
        Route::post('/addenseignant',[EnseignantController::class,'store']);
        Route::put('/updateenseignant/{id}',[EnseignantController::class,'update']);
        Route::delete('/removeenseignant/{id}', [EnseignantController::class,'destroy']);
        
        // getion de post
        Route::get('/posts/{id}',[PostController::class, 'show']);
       Route::get('/posts',[PostController::class, 'index']);
        Route::post('/addpost',[PostController::class,'store']);
        Route::put('/updatepost/{id}',[PostController::class,'update']);
        Route::delete('/removepost/{id}', [PostController::class,'destroy']);
        
        // getion de evenement
        Route::get('/evenements/{id}',[EvenementController::class, 'show']);
        Route::get('/evenements',[EvenementController::class, 'index']);
        Route::post('/addevenement',[EvenementController::class,'store']);
        Route::put('/updateevenement/{id}',[EvenementController::class,'update']);
        Route::delete('/removeevenement/{id}', [EvenementController::class,'destroy']);
        
    });
       
       
       
       
       
    // getion de post
   
Route::middleware(['auth:admins','checkrole:SuperAdmin'])->group(function () { 
Route::get('/admins/{id}',[AdminController::class, 'show']);
Route::get('/admins',[AdminController::class, 'index']);
Route::post('/addadmin',[AdminController::class,'store']);
Route::put('/updateadmin/{id}',[AdminController::class,'update']);
Route::delete('/removeadmin/{id}', [AdminController::class,'destroy']);
 });

Route::middleware(['auth:enseignants','checkrole:enseignant'])->group(function () { 
Route::get('/homework/{id}',[HomeworkController::class, 'enseignant']);
Route::get('/homeworks/{id}',[HomeworkController::class, 'show']);
Route::get('/enseignants/{id}',[EnseignantController::class, 'show']);

Route::get('/homeworks',[HomeworkController::class, 'index']);
Route::post('/addhomework',[HomeworkController::class,'store']);
Route::put('/updatehomework/{id}',[HomeworkController::class,'update']);
Route::delete('/removehomework/{id}', [HomeworkController::class,'destroy']);
  });
  Route::middleware(['auth:parents', 'checkrole:parent'])->prefix('parent')->group(function () { 
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/addreclamation',[ReclamationController::class,'store']);
    Route::put('/updatereclamation/{id}',[ReclamationController::class,'update']);
    Route::delete('/removereclamation/{id}', [ReclamationController::class,'destroy']);
    Route::get('/reclamations/{id}',[ReclamationController::class, 'reclamation']);
    Route::get('/enfants/{id}',[EnfantController::class, 'enfant']);
    Route::get('/evenements',[EvenementController::class, 'index']);
});
Route::post('messages',[ChatController::class,'message']);