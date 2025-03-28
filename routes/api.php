<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\CommunicationPlatformController;
use App\Http\Controllers\CommunityChecklistController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\FaithMilestoneController;
use App\Http\Controllers\PeopleGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SystemLanguageController;
use App\Http\Controllers\SystemLanguageWordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Models\Community;
use Illuminate\Support\Facades\Route;

// Route::post('register', [UserController::class, 'register'])->name('user.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:sanctum')->group(function () {
    // Authentication
    Route::prefix('auth')->group(function () {
        Route::get('user', [AuthController::class, 'getUser'])->name('auth.user');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    // USERS
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'browse'])->name('user.browse');
        Route::post('/', [UserController::class, 'create'])->name('user.create');
        Route::get('/list', [UserController::class, 'list'])->name('user.list');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [UserController::class, 'update'])->name('user.update');
            Route::get('/', [UserController::class, 'view'])->name('user.view');
            Route::delete('/', [UserController::class, 'delete'])->name('user.delete');
            Route::delete('trash', [UserController::class, 'trash'])->name('user.trash');
            Route::post('restore', [UserController::class, 'restore'])->name('user.restore');
        });

        // USER ROLE
        Route::prefix('roles')->group(function () {
            Route::get('/', [UserRoleController::class, 'browse'])->name('user_role.browse');
            Route::post('/', [UserRoleController::class, 'create'])->name('user_role.create');

            Route::prefix('id/{id}')->group(function () {
                Route::put('/', [UserRoleController::class, 'update'])->name('user_role.update');
                Route::get('/', [UserRoleController::class, 'view'])->name('user_role.view');
                Route::delete('/', [UserRoleController::class, 'delete'])->name('user_role.delete');
                Route::delete('trash', [UserRoleController::class, 'trash'])->name('user_role.trash');
                Route::post('restore', [UserRoleController::class, 'restore'])->name('user_role.restore');
            });
        }); // e.o USER ROLE
    }); // e.o USERS

    // LANGUAGES
    Route::prefix('languages')->group(function () {
        Route::get('/', [SystemLanguageController::class, 'browse'])->name('language.browse');
        Route::post('/', [SystemLanguageController::class, 'create'])->name('language.create');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [SystemLanguageController::class, 'update'])->name('language.update');
            Route::get('/', [SystemLanguageController::class, 'view'])->name('language.view');
            Route::delete('/', [SystemLanguageController::class, 'delete'])->name('language.delete');
            Route::delete('trash', [SystemLanguageController::class, 'trash'])->name('language.trash');
        });

        // WORDS
        Route::prefix('words')->group(function () {
            Route::get('/', [SystemLanguageWordController::class, 'browse'])->name('language_word.browse');
            Route::post('/', [SystemLanguageWordController::class, 'create'])->name('language_word.create');

            Route::prefix('id/{id}')->group(function () {
                Route::put('/', [SystemLanguageWordController::class, 'update'])->name('language_word.update');
                Route::get('/', [SystemLanguageWordController::class, 'view'])->name('language_word.view');
                Route::delete('/', [SystemLanguageWordController::class, 'delete'])->name('language_word.delete');
                Route::delete('trash', [SystemLanguageWordController::class, 'trash'])->name('language_word.trash');
            });
        }); // e.o WORDS
    }); // e.o LANGUAGES

    // PEOPLE GROUPS
    Route::prefix('people-groups')->group(function () {
        Route::get('/', [PeopleGroupController::class, 'browse'])->name('people_group.browse');
        Route::post('/', [PeopleGroupController::class, 'create'])->name('people_group.create');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [PeopleGroupController::class, 'update'])->name('people_group.update');
            Route::get('/', [PeopleGroupController::class, 'view'])->name('people_group.view');
            Route::delete('/', [PeopleGroupController::class, 'delete'])->name('people_group.delete');
            Route::delete('trash', [PeopleGroupController::class, 'trash'])->name('people_group.trash');
            Route::post('restore', [PeopleGroupController::class, 'restore'])->name('people_group.restore');
        });
    }); // e.o PEOPLE GROUPS

    // DENOMINATIONS
    Route::prefix('denominations')->group(function () {
        Route::get('/', [DenominationController::class, 'browse'])->name('denomination.browse');
        Route::post('/', [DenominationController::class, 'create'])->name('denomination.create');
        Route::get('/list', [DenominationController::class, 'list'])->name('denominations.list');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [DenominationController::class, 'update'])->name('denomination.update');
            Route::get('/', [DenominationController::class, 'view'])->name('denomination.view');
            Route::delete('/', [DenominationController::class, 'delete'])->name('denomination.delete');
            Route::delete('trash', [DenominationController::class, 'trash'])->name('denomination.trash');
            Route::post('restore', [DenominationController::class, 'restore'])->name('denomination.restore');
        });
    }); // e.o DENOMINATIONS

    // COMMUNICATION PLATFORMS
    Route::prefix('communication-platforms')->group(function () {
        Route::get('/', [CommunicationPlatformController::class, 'browse'])->name('communication_platform.browse');
        Route::post('/', [CommunicationPlatformController::class, 'create'])->name('communication_platform.create');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [CommunicationPlatformController::class, 'update'])->name('communication_platform.update');
            Route::get('/', [CommunicationPlatformController::class, 'view'])->name('communication_platform.view');
            Route::delete('/', [CommunicationPlatformController::class, 'delete'])
                ->name('communication_platform.delete');

            Route::delete('trash', [CommunicationPlatformController::class, 'trash'])
                ->name('communication_platform.trash');

            Route::post('restore', [CommunicationPlatformController::class, 'restore'])
                ->name('communication_platform.restore');
        });
    }); // e.o COMMUNICATION PLATFORMS

    // FAITH MILESTONES
    Route::prefix('faith-milestones')->group(function () {
        Route::get('/', [FaithMilestoneController::class, 'browse'])->name('faith_milestone.browse');
        Route::post('/', [FaithMilestoneController::class, 'create'])->name('faith_milestone.create');
        Route::post('/upload-icon', [FaithMilestoneController::class, 'uploadIcon'])
            ->name('faith_milestone.upload_icon');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [FaithMilestoneController::class, 'update'])->name('faith_milestone.update');
            Route::get('/', [FaithMilestoneController::class, 'view'])->name('faith_milestone.view');
            Route::delete('/', [FaithMilestoneController::class, 'delete'])->name('faith_milestone.delete');
            Route::delete('trash', [FaithMilestoneController::class, 'trash'])->name('faith_milestone.trash');
            Route::post('restore', [FaithMilestoneController::class, 'restore'])->name('faith_milestone.restore');
        });
    }); // e.o FAITH MILESTONES

    // CONTACTS
    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'browse'])->name('contact.browse');
        Route::post('/', [ContactController::class, 'create'])->name('contact.create');
        Route::get('/list', [ContactController::class, 'list'])->name('contact.list');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [ContactController::class, 'update'])->name('contact.update');
            Route::get('/', [ContactController::class, 'view'])->name('contact.view');
            Route::delete('/', [ContactController::class, 'delete'])->name('contact.delete');
            Route::delete('trash', [ContactController::class, 'trash'])->name('contact.trash');
            Route::post('restore', [ContactController::class, 'restore'])->name('contact.restore');
        });
    }); // e.o CONTACTS

    // CHURCHES
    Route::prefix('churches')->group(function () {
        Route::get('/', [ChurchController::class, 'browse'])->name('church.browse');
        Route::post('/', [ChurchController::class, 'create'])->name('church.create');
        Route::get('/list', [ChurchController::class, 'list'])->name('church.list');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [ChurchController::class, 'update'])->name('church.update');
            Route::get('/', [ChurchController::class, 'view'])->name('church.view');
            Route::delete('/', [ChurchController::class, 'delete'])->name('church.delete');
            Route::delete('trash', [ChurchController::class, 'trash'])->name('church.trash');
            Route::post('restore', [ChurchController::class, 'restore'])->name('church.restore');
        });
    }); // e.o CHURCHES

    // COMMUNITIES
    Route::prefix('communities')->group(function () {
        Route::get('/', [CommunityController::class, 'browse'])->name('communities.browse');
        Route::post('/', [CommunityController::class, 'create'])->name('communities.create');
        Route::get('/list', [CommunityController::class, 'list'])->name('communities.list');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [CommunityController::class, 'update'])->name('communities.update');
            Route::get('/', [CommunityController::class, 'view'])->name('communities.view');
            Route::delete('/', [CommunityController::class, 'delete'])->name('communities.delete');
            Route::delete('trash', [CommunityController::class, 'trash'])->name('communities.trash');
            Route::post('restore', [CommunityController::class, 'restore'])->name('communities.restore');
        });
    }); // e.o COMMUNITIES

    // SETTINGS
    Route::prefix('settings')->group(function () {
        Route::get('/statuses', [SettingController::class, 'browseStatuses'])->name('setting.browseStatuses');
        Route::get('/prayers', [SettingController::class, 'getPrayers'])->name('setting.getPrayers');
    }); // e.o SETTINGS

    // PROFILE
    Route::prefix('profile')->group(function () {
        Route::put('/change-password', [ProfileController::class, 'changePassword'])
            ->name('profile.changePassword');
    }); // e.o PROFILE

    // COMMUNITY CHECKLIST
    Route::prefix('community-checklists')->group(function () {
        Route::get('/', [CommunityChecklistController::class, 'browse'])->name('communityChecklist.browse');
        Route::post('/', [CommunityChecklistController::class, 'create'])->name('communityChecklist.create');
        Route::get('/list', [CommunityChecklistController::class, 'list'])->name('communityChecklist.list');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [CommunityChecklistController::class, 'update'])->name('communityChecklist.update');
            Route::get('/', [CommunityChecklistController::class, 'view'])->name('communityChecklist.view');
            Route::delete('/', [CommunityChecklistController::class, 'delete'])->name('communityChecklist.delete');
            Route::delete('trash', [CommunityChecklistController::class, 'trash'])->name('communityChecklist.trash');
            Route::post('restore', [CommunityChecklistController::class, 'restore'])
                ->name('communityChecklist.restore');
        });
    }); // e.o COMMUNITY CHECKLIST
});
