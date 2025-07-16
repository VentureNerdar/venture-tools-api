<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\CommunicationPlatformController;
use App\Http\Controllers\CommunityChecklistController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\FaithMilestoneController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\MovementNotificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeopleGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SystemLanguageController;
use App\Http\Controllers\SystemLanguageWordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PrayerPromptController;
use Illuminate\Support\Facades\Route;

// Route::post('register', [UserController::class, 'register'])->name('user.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::prefix('registration')->group(function () {
    Route::prefix('options')->group(function () {
        Route::get('/', [RegistrationController::class, 'getRegistrationOptions'])->name('registration.options');
    });

    Route::prefix('register')->group(function () {
        Route::post('/', [RegistrationController::class, 'register'])->name('registration.register');
    });
});

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

        // Device management routes

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [UserController::class, 'update'])->name('user.update');
            Route::get('/', [UserController::class, 'view'])->name('user.view');
            Route::delete('/', [UserController::class, 'delete'])->name('user.delete');
            Route::delete('trash', [UserController::class, 'trash'])->name('user.trash');
            Route::post('restore', [UserController::class, 'restore'])->name('user.restore');

            Route::prefix('/devices')->group(function () {
                Route::get('/', [UserController::class, 'getDevices'])->name('user.devices');
                Route::post('/', [UserController::class, 'registerDevice'])->name('user.registerDevice');
                Route::delete('/{device_id}', [UserController::class, 'removeDevice'])->name('user.removeDevice');
                Route::delete('/', [UserController::class, 'removeOtherDevices'])->name('user.removeOtherDevices');
                Route::put('/{device_id}', [UserController::class, 'updateDevice'])->name('user.updateDevice');
            });
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

        Route::prefix('translations')->group(function () {
            Route::post('/', [SystemLanguageController::class, 'createTranslation'])
                ->name('language.create_translation');

            Route::put('/{id}', [SystemLanguageController::class, 'updateTranslation'])
                ->name('language.update_translation');
        });
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
        Route::post('/planters', [ChurchController::class, 'createChurchPlanters'])->name('church.planters.create');

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
        Route::post('/update-all', [CommunityChecklistController::class, 'updateAll'])->name('communityChecklist.updateAll');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [CommunityChecklistController::class, 'update'])->name('communityChecklist.update');
            Route::get('/', [CommunityChecklistController::class, 'view'])->name('communityChecklist.view');
            Route::delete('/', [CommunityChecklistController::class, 'delete'])->name('communityChecklist.delete');
            Route::delete('trash', [CommunityChecklistController::class, 'trash'])->name('communityChecklist.trash');
            Route::post('restore', [CommunityChecklistController::class, 'restore'])
                ->name('communityChecklist.restore');
        });
    }); // e.o COMMUNITY CHECKLIST

    // NOTIFICATIONS
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'browse'])->name('notification.browse');
        Route::post('/', [NotificationController::class, 'create'])->name('notification.create');
        Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('notification.sendNotification');

        // Token management routes
        Route::post('/register-token', [NotificationController::class, 'registerToken'])->name('notification.registerToken');
        Route::delete('/remove-token/{token}', [NotificationController::class, 'removeToken'])->name('notification.removeToken');
        Route::delete('/remove-device/{device_id}', [NotificationController::class, 'removeDevice'])->name('notification.removeDevice');
        Route::get('/my-tokens', [NotificationController::class, 'getTokens'])->name('notification.getTokens');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [NotificationController::class, 'update'])->name('notification.update');
        });
    });
    // e.o NOTIFICATIONS

    // MOVEMENTS
    Route::prefix('movements')->group(function () {
        Route::get('/', [MovementController::class, 'browse'])->name('movement.browse');
        Route::post('/', [MovementController::class, 'create'])->name('movement.create');
        Route::get('/list', [MovementController::class, 'list'])->name('movements.list');
        Route::get('/users', [MovementController::class, 'getMovementUsers'])->name('movements.users');
        Route::post('/verify-user', [MovementController::class, 'verifyUser'])->name('movements.verifyUser');

        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [MovementController::class, 'update'])->name('movement.update');
            Route::get('/', [MovementController::class, 'view'])->name('movement.view');
            Route::delete('/', [MovementController::class, 'delete'])->name('movement.delete');
            Route::delete('trash', [MovementController::class, 'trash'])->name('movement.trash');
            Route::post('restore', [MovementController::class, 'restore'])->name('movement.restore');
        });
    });
    // e.o MOVEMENTS

    // MOVEMENT NOTIFICATIONS
    Route::prefix('movement-notifications')->group(function () {
        Route::get('/', [MovementNotificationController::class, 'browse'])->name('movementNotification.browse');
        Route::post('/', [MovementNotificationController::class, 'create'])->name('movementNotification.create');
        Route::delete('id/{id}', [MovementNotificationController::class, 'delete'])->name('movementNotification.delete');
    });
    // e.o MOVEMENT NOTIFICATIONS

    // PRAYER PROMPTS
    Route::prefix('prayer-prompts')->group(function () {
        Route::get('/', [PrayerPromptController::class, 'browse'])->name('prayerPrompt.browse');
        Route::post('/', [PrayerPromptController::class, 'create'])->name('prayerPrompt.create');
        Route::get('/list', [PrayerPromptController::class, 'list'])->name('prayerPrompts.list');
        Route::prefix('id/{id}')->group(function () {
            Route::put('/', [PrayerPromptController::class, 'update'])->name('prayerPrompt.update');
            Route::get('/', [PrayerPromptController::class, 'view'])->name('prayerPrompt.view');
            Route::delete('/', [PrayerPromptController::class, 'delete'])->name('prayerPrompt.delete');
            Route::delete('trash', [PrayerPromptController::class, 'trash'])->name('prayerPrompt.trash');
            Route::post('restore', [PrayerPromptController::class, 'restore'])->name('prayerPrompt.restore');
        });
    });
    // e.o PRAYER PROMPTS

    // DASHBOARD
    Route::prefix('dashboard')->group(function () {
        Route::get('/insight', [DashboardController::class, 'getInsightData'])
            ->name('dashboard.insightData');
        Route::get('/church-locations', [DashboardController::class, 'getLocationsOfChurch'])
            ->name('dashboard.locationsOfChurch');
        Route::get('/generational-churches-by-tree', [DashboardController::class, 'getGenerationalChurchesByTree'])
            ->name('dashboard.generationalChurchesByTree');
        Route::get('/generational-churches-by-graph', [DashboardController::class, 'getGenerationalChurchesByGraph'])
            ->name('dashboard.generationalChurchesByGraph');
        Route::get('/people-groups', [DashboardController::class, 'getPeopleGroups'])
            ->name('dashboard.peopleGroups');
    });
    // e.o DASHBOARD
});
