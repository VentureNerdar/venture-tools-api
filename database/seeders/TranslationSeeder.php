<?php

namespace Database\Seeders;

use App\Models\SystemLanguage;
use App\Models\SystemLanguageTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('system_language_translations')->truncate();

        $languages = [
            ['English', 'en'],
            ['Nepali', 'ne'],
            ['Myanmar', 'mm']
        ];

        foreach ($languages as $language) {
            SystemLanguage::firstOrCreate([
                'name' => $language[0],
                'label' => $language[0],
                'locale' => $language[1],
                'is_enabled' => true
            ]);
        }


        $words = [
            // Navigation
            'venture' => [
                'en' => 'Venture',
                'mm' => 'ဗန်းချား',
                'ne' => 'उद्यम',
            ],
            'venture_tool' => [
                'en' => 'Venture Tools',
                'mm' => 'ဗန်းချား',
                'ne' => 'उद्यम उपकरणहरू'
            ],
            'contact' => [
                'en' => 'Contact',
                'mm' => 'အဆက်အသွယ်',
                'ne' => 'सम्पर्क गर्नुहोस्',
            ],
            'contacts' => [
                'en' => 'Contacts',
                'mm' => 'အဆက်အသွယ်များ',
                'ne' => 'सम्पर्कहरू',
            ],
            'church' => [
                'en' => 'Church',
                'mm' => 'ဘုရားကျောင်း',
                'ne' =>  'चर्च',
            ],
            'churches' => [
                'en' => 'Churches',
                'mm' => 'ဘုရားကျောင်းများ',
                'ne' => 'चर्चहरू',
            ],
            'community' => [
                'en' => 'Community',
                'mm' => 'အသိုင်းအ၀ိုင်း',
                'ne' => 'समुदाय',
            ],
            'communities' => [
                'en' => 'Communities',
                'mm' => 'အသိုင်းအ၀ိုင်းများ',
                'ne' => 'समुदायहरू',
            ],
            'settings' => [
                'en' => 'Settings',
                'mm' => 'ဆက်တင်များ',
                'ne' => 'सेटिङहरू',
            ],
            'user' => [
                'en' => 'User',
                'mm' => 'အသုံးပြုသူ',
                'ne' => 'प्रयोगकर्ता',
            ],
            'this_user_is_in_trash' => [
                'en' => 'This user is in trash.',
                'mm' => 'ဒီအသုံးပြုသူသည် ဖျက်သိမ်းထားသည့်အထဲ ရောက်နေသည်',
                'ne' => 'यो प्रयोगकर्ता रद्दीको टोकरीमा छ।'
            ],
            'this_user_role_is_in_trash' => [
                'en' => 'This user role is in trash',
                'mm' => 'ဒီအသုံးပြုသူ အခန်းကဏ္ဍသည် ဖျက်သိမ်းထားသည့်အထဲ ရောက်နေသည်',
                'ne' =>  'यो प्रयोगकर्ता भूमिका रद्दीको टोकरीमा छ।'
            ],
            'this_contact_is_in_trash' => [
                'en' => 'This contact is in trash.',
                'mm' => 'ဒီအဆက်အသွယ်သည် ဖျက်သိမ်းထားသည့်အထဲ ရောက်နေသည်',
                'ne' => 'यो सम्पर्क रद्दीको टोकरीमा छ।'
            ],
            'users' => [
                'en' => 'Users',
                'mm' => 'အသုံးပြုသူများ',
                'ne' => 'प्रयोगकर्ताहरू',
            ],
            'language_preference' => [
                'en' => 'Language Preference',
                'mm' => 'နှစ်သက်သော ဘာသာစကား',
                'ne' => 'भाषा प्राथमिकता'
            ],
            'manage_users' => [
                'en' => 'Manage Users',
                'mm' => 'အသုံးပြုသူများကို စီမံခြင်း',
                'ne' => 'प्रयोगकर्ताहरू व्यवस्थापन गर्नुहोस्'
            ],
            'configuration' => [
                'en' => 'Configuration',
                'mm' => 'ဖွဲ့စည်းမှု',
                'ne' => 'कन्फिगरेसन',
            ],
            'configurations' => [
                'en' => 'Configurations',
                'mm' => 'ဖွဲ့စည်းမှုများ',
                'ne' => 'कन्फिगरेसनहरू',
            ],
            'translation' => [
                'en' => 'Translation',
                'mm' => 'ဘာသာပြန်ချက်',
                'ne' => 'अनुवाद',
            ],
            'translations' => [
                'en' => 'Translations',
                'mm' => 'ဘာသာပြန်ချက်များ',
                'ne' => 'अनुवादहरू',
            ],
            'language' => [
                'en' => 'Language',
                'mm' => 'ဘာသာစကား',
                'ne' => 'भाषा',
            ],
            'languages' => [
                'en' => 'Languages',
                'mm' => 'ဘာသာစကားများ',
                'ne' => 'भाषाहरू'
            ],
            'prayers' => [
                'en' => 'Prayers',
                'mm' => 'ဆုတောင်းသူများ',
                'ne' => 'प्रार्थनाहरू'
            ],
            'profile' => [
                'en' => 'Profile',
                'mm' => 'မိမိအချက်အလက်',
                'ne' => 'प्रोफाइल',
            ],
            'dashboard' => [
                'en' => 'Dashboard',
                'mm' =>  'ဒက်ရှ်ဘုတ်',
                'ne' => 'ड्यासबोर्ड',
            ],
            'communication_platforms' => [
                'en' => 'Communication Platforms',
                'mm' =>  'အဖွဲ့အစည််း ပလက်ဖောင်း',
                'ne' => 'सञ्चार प्लेटफार्महरू'
            ],
            'this_communication_platform_is_in_trash' => [
                'en' => 'This communication platform is in trash',
                'mm' => 'ဒီအဖွဲ့အစည်း ပလက်ဖောင်းသည် ဖျက်သိမ်းထားသည့်အထဲရောက်နေသည်',
                'ne' => 'यो सञ्चार प्लेटफर्म रद्दीको टोकरीमा छ।'
            ],
            'community_checklists' => [
                'en' => 'Community Checklists',
                'mm' =>  'အဖွဲ့အစည်း မှတ်စုများ',
                'ne' => 'सामुदायिक चेकलिस्टहरू'
            ],
            'community_checklist' => [
                'en' => 'Community Checklist',
                'mm' => 'အဖွဲ့အစည်း မှတ်စုများ',
                'ne' => 'सामुदायिक चेकलिस्ट'
            ],
            'loading_maximum_20_contacts._type_in_the_name_of_the_contact_to_search' => [
                'en' => 'Loading maximum 20 contacts. Type in the name of the contact to search.',
                'mm' => 'အများဆုံး အဆက်အသွယ် 20 ကို တင်နေသည်။ ရှာဖွေရန် အဆက်အသွယ်အမည်ကို ရိုက်ထည့်ပါ။',
                'ne' => 'अधिकतम २० सम्पर्कहरू लोड हुँदै। खोज्न सम्पर्कको नाम टाइप गर्नुहोस्।'
            ],
            'loading_maximum_20_users._type_in_the_name_of_the_user_to_search' => [
                'en' => 'Loading maximum 20 users. Type in the name of the user to search.',
                'mm' => 'အများဆုံး အသုံးပြုသူ 20 ကို တင်နေသည်။ ရှာဖွေရန် အသုံးပြုသူ၏ အမည်ကို ရိုက်ထည့်ပါ။',
                'ne' => 'अधिकतम २० प्रयोगकर्ताहरू लोड हुँदै। खोज्नको लागि प्रयोगकर्ताको नाम टाइप गर्नुहोस्।'
            ],

            // Actions
            'create' => [
                'en' => 'Create',
                'mm' => 'ဖန်တီး',
                'ne' => 'सिर्जना गर्नुहोस्',
            ],
            'edit' => [
                'en' => 'Edit',
                'mm' => 'ပြုပြင်',
                'ne' => 'सम्पादन गर्नुहोस्',
            ],
            'list' => [
                'en' => 'List',
                'mm' => 'စာရင်း',
                'ne' => 'सूची'
            ],
            'view' => [
                'en' => 'View',
                'mm' => 'ကြည့်ရှု',
                'ne' => 'हेर्नुहोस्'
            ],
            'delete' => [
                'en' => 'Delete',
                'mm' => 'ဖျက်ပစ်',
                'ne' => 'मेट्नुहोस्'
            ],
            'trash' => [
                'en' => 'Delete',
                'mm' =>  'ဖျက်မည်',
                'ne' => 'रद्दीटोकरी'
            ],
            'delete_permanently' => [
                'en' => 'Delete Permanently',
                'mm' => 'အပြီးတိုင်ဖျက်မည်',
                'ne' => 'स्थायी रूपमा मेटाउनुहोस्'
            ],
            'name' => [
                'en' => 'Name',
                'mm' => 'နာမည်',
                'ne' => 'नाम',
            ],
            'label' => [
                'en' => 'Label',
                'mm' => 'လေဘယ်',
                'ne' => 'लेबल'
            ],
            'locale' => [
                'en' => 'Locale',
                'mm' => '‌ဒေသဘာသာ',
                'ne' => 'लोकेल'
            ],
            'active_status' => [
                'en' => 'Active Status',
                'mm' => 'လက်ရှိအခြေအနေ',
                'ne' => 'सक्रिय स्थिति',
            ],
            'is_enabled' => [
                'en' => 'Is Enabled',
                'mm' => 'ဖွင့်ထားသည်',
                'ne' => 'सक्षम गरिएको छ'
            ],
            'save' => [
                'en' => 'Save',
                'mm' => 'သိမ်းဆည်း',
                'ne' => 'बचत गर्नुहोस्'
            ],
            'save_changes' => [
                'en' => 'Save Changes',
                'mm' => 'ပြောင်းလဲမှုများသိမ်းဆည်း',
                'ne' => 'परिवर्तनहरू बचत गर्नुहोस्',
            ],
            'cancel' => [
                'en' => 'Cancel',
                'mm' => 'ပယ်ဖျက်သည်',
                'ne' => 'रद्द गर्नुहोस्'
            ],
            'close' => [
                'en' => 'Close',
                'mm' => 'ပိတ်ရန်',
                'ne' => 'बन्द गर्नुहोस्'
            ],
            'sign_out' => [
                'en' => 'Sign Out',
                'mm' => 'ထွက်ရန်',
                'ne' => 'साइन आउट गर्नुहोस्',
            ],
            'log_out' => [
                'en' => 'Log Out',
                'mm' => 'ထွက်ရန်',
                'ne' => 'लग आउट गर्नुहोस्',
            ],
            'page' => [
                'en' => 'Page',
                'mm' => 'စာမျက်နှာ',
                'ne' => 'पृष्ठ',
            ],
            'total' => [
                'en' => 'Total',
                'mm' => 'စုစုပေါင်း',
                'ne' => 'कुल',
            ],
            'select' => [
                'en' => 'Select',
                'mm' =>  'ရွေးချယ်ပါ',
                'ne' => 'चयन गर्नुहोस्',
            ],
            'input' => [
                'en' => 'Input',
                'mm' =>  'ဖြည့်ပါ',
                'ne' => 'इनपुट'
            ],
            'update' => [
                'en' => 'Update',
                'mm' =>  'ပြောင်းလဲရန်',
                'ne' => 'अपडेट गर्नुहोस्',
            ],
            'restore' => [
                'en' => 'Restore',
                'mm' => 'ပြန်လည်ရယူရန်',
                'ne' => 'पुनर्स्थापना गर्नुहोस्'
            ],
            'change_password' => [
                'en' => 'Change Password',
                'mm' =>  'စကားဝှက်ပြောင်းလဲရန်',
                'ne' => 'पासवर्ड परिवर्तन गर्नुहोस्',
            ],
            'password' => [
                'en' => 'Password',
                'mm' => 'စကားဝှက်',
                'ne' => 'पासवर्ड'
            ],
            'you_will_need_to_log_in_again_after_you_chang_your_password' => [
                'en' => 'You will need to log in again after you change your password.',
                'mm' => 'စကားဝှက်ပြောင်းလဲပြီးနောက် အကောင့်ပြန်ဝင်ရန် လိုအပ်ပါလိမ့်မည်',
                'ne' => 'तपाईंले आफ्नो पासवर्ड परिवर्तन गरेपछि फेरि लग इन गर्नुपर्नेछ।',
            ],
            'current_password' => [
                'en' => 'Current Password',
                'mm' => 'လက်ရှိ စကားဝှက်',
                'ne' => 'हालको पासवर्ड'
            ],
            'new_password' => [
                'en' => 'New Password',
                'mm' => 'စကားဝှက်အသစ်',
                'ne' => 'नयाँ पासवर्ड'
            ],
            'confirm_new_password' => [
                'en' => 'Confirm New Password',
                'mm' => 'စကားဝှက်အသစ် အတည်ပြုပါ',
                'ne' => 'नयाँ पासवर्ड पुष्टि गर्नुहोस्'
            ],
            'quick_filter' => [
                'en' => 'Quick Filter',
                'mm' => 'စစ်ထုတ်ခြင်း',
                'ne' => 'द्रुत फिल्टर'
            ],
            'confirm_deletion' => [
                'en' => 'Confirm Deletion',
                'mm' => 'ဖျက်သိမ်းမှု အတည်ပြုခြင်း',
                'ne' => 'मेटाउने पुष्टि गर्नुहोस्'
            ],
            'confirm_delete' => [
                'en' => 'Confirm Delete',
                'mm' => 'ဖျက်သိမ်းမှု အတည်ပြုခြင်း',
                'ne' => 'मेटाउने पुष्टि गर्नुहोस्'
            ],
            'are_you_sure_you_cannot_undo_this_action_afterwards' => [
                'en' => 'Are you sure? You cannot undo this action afterwards.',
                'mm' => 'ဖျက်မှာသေချာပါသလား။ ဖျက်ပြီးလျှင် ပြန်လည်ရယူဖို့ မဖြစ်နိုင်တော့ပါ',
                'ne' => 'के तपाईं पक्का हुनुहुन्छ? तपाईं पछि यो कार्यलाई पूर्ववत गर्न सक्नुहुन्न।',
            ],

            // Language
            'language_information' => [
                'en' => 'Language Information',
                'mm' => 'ဘာသာစကားအချက်အလက်',
                'ne' => 'भाषा जानकारी',
            ],
            'edit_language' => [
                'en' => 'Edit Language',
                'mm' => 'ဘာသာစကားပြုပြင်',
                'ne' => 'भाषा सम्पादन गर्नुहोस्'
            ],
            'create_language' => [
                'en' => 'Create Language',
                'mm' => 'ဘာသာစကားဖန်တီး',
                'ne' => 'भाषा सिर्जना गर्नुहोस्',
            ],
            'save_language_information' => [
                'en' => 'Save Language Information',
                'mm' => 'ဘာသာစကားအချက်အလက်သိမ်းဆည်း',
                'ne' => 'भाषा जानकारी बचत गर्नुहोस्'
            ],

            'save_translation' => [
                'en' => 'Save Translation',
                'mm' => 'ဘာသာပြန်ချက်သိမ်းဆည်း',
                'ne' => 'अनुवाद बचत गर्नुहोस्'
            ],

            'user_roles' => [
                'en' => 'User Roles',
                'mm' => 'အသုံးပြုသူအခန်းကဏ္ဍများ',
                'ne' => 'प्रयोगकर्ता भूमिकाहरू'
            ],
            'user_role' => [
                'en' => 'User Role',
                'mm' => 'အသုံးပြုသူ အခန်းကဏ္ဍများ',
                'ne' => 'प्रयोगकर्ताको भूमिका',
            ],

            'all_roles' => [
                'en' => 'All Roles',
                'mm' => 'အခန်းကဏ္ဍအားလုံး',
                'ne' => 'सबै भूमिकाहरू',
            ],

            'add_user' => [
                'en' => 'Add User',
                'mm' => 'အသုံးပြုသူထည့်သွင်းပါ',
                'ne' => 'प्रयोगकर्ता थप्नुहोस्',
            ],

            'search' => [
                'en' => 'Search',
                'mm' => 'ရှာဖွေပါ',
                'ne' => 'खोज्नुहोस्',
            ],

            'add_contact' => [
                'en' => 'Add Contact',
                'mm' => 'အဆက်အသွယ်ထည့်သွင်းပါ',
                'ne' => 'सम्पर्क थप्नुहोस्',
            ],

            'no_data' => [
                'en' => 'No Data',
                'mm' => 'အချက်အလက်မရှိပါ',
                'ne' => 'कुनै डाटा छैन'
            ],

            'contact_status' => [
                'en' => 'Contact Status',
                'mm' => 'အဆက်အသွယ်အခြေအနေ',
                'ne' => 'सम्पर्क स्थिति'
            ],

            'faith_status' => [
                'en' => 'Faith Status',
                'mm' => 'ယုံကြည်ခြင်းအခြေအနေ',
                'ne' => 'विश्वास स्थिति'
            ],

            'assigned_to' => [
                'en' => 'Assigned To',
                'mm' => 'တာဝန်ပေးထားသူ',
                'ne' => 'लाई तोकिएको छ'
            ],

            'coached_by' => [
                'en' => 'Coached By',
                'mm' => 'သင်ကြားပေးသူ',
                'ne' => 'द्वारा प्रशिक्षित'
            ],

            'basic_information' => [
                'en' => 'Basic Information',
                'mm' => 'အခြေခံအချက်အလက်',
                'ne' => 'आधारभूत जानकारी'
            ],

            'faith' => [
                'en' => 'Faith',
                'mm' => 'ယုံကြည်ခြင်း',
                'ne' => 'विश्वास'
            ],

            'contact_information' => [
                'en' => 'Contact Information',
                'mm' => 'အဆက်အသွယ်အချက်အလက်',
                'ne' => 'सम्पर्क जानकारी'
            ],

            'baptism' => [
                'en' => 'Baptism',
                'mm' => 'ဗတ္တိဇံ',
                'ne' => 'बप्तिस्मा',
            ],

            'current_prayers' => [
                'en' => 'Current Prayers',
                'mm' => 'လက်ရှိဆုတောင်းချက်များ',
                'ne' => 'वर्तमान प्रार्थनाहरू'
            ],

            'select_a_status' => [
                'en' => 'Select a Status',
                'mm' => 'အခြေအနေရွေးပါ',
                'ne' => 'स्थिति चयन गर्नुहोस्',
            ],

            'select_a_community' => [
                'en' => 'Select a community',
                'mm' => 'အဖွဲ့အစည်းတစ်ခုကို ရွေးပါ',
                'ne' => 'समुदाय चयन गर्नुहोस्'
            ],

            'nickname' => [
                'en' => 'Nickname',
                'mm' => 'အိမ်ခေါ်နာမည်',
                'ne' => 'उपनाम',
            ],

            'gender' => [
                'en' => 'Gender',
                'mm' => 'ကျား/မ',
                'ne' => 'लिङ्ग'

            ],

            'age' => [
                'en' => 'Age',
                'mm' => 'အသက်',
                'ne' => 'उमेर'
            ],

            'people_group' => [
                'en' => 'People Group',
                'mm' => 'လူမျိုးအုပ်စု',
                'ne' => 'मान्छे समूह',
            ],

            'people_groups' => [
                'en' => 'People Groups',
                'mm' => 'လူမျိုးစုအုပ်စုများ',
                'ne' => 'मानिसहरू समूहहरू',
            ],

            'baptism_date' => [
                'en' => 'Baptism Date',
                'mm' => 'ဗတ္တိဇံခံယူသည့်ရက်',
                'ne' => 'बप्तिस्मा मिति',
            ],

            'select_an_option' => [
                'en' => 'Select an Option',
                'mm' => 'ရွေးချယ်မှုတစ်ခုကို ရွေးချယ်ပါ။',
                'ne' => 'एक विकल्प चयन गर्नुहोस्'
            ],

            'male' => [
                'en' => 'Male',
                'mm' => 'ကျား',
                'ne' => 'पुरुष'
            ],

            'female' => [
                'en' => 'Female',
                'mm' => 'မ',
                'ne' => 'महिला'
            ],

            'add_multiple_contact_information_for_each_platform' => [
                'en' => 'Add multiple contact information for each platform',
                'mm' => 'တစ်ခုအတွင်းအဆက်အသွယ်အချက်အလက်များထည့်သွင်းပါ',
                'ne' => 'प्रत्येक प्लेटफर्मको लागि धेरै सम्पर्क जानकारी थप्नुहोस्'
            ],

            'faith_milestones' => [
                'en' => 'Faith Milestones',
                'mm' => 'ယုံကြည်ခြင်းမှတ်တိုင်များ',
                'ne' => 'विश्वास माइलस्टोनहरू'
            ],

            'baptized_by' => [
                'en' => 'Baptized By',
                'mm' => 'နှစ်ခြင်းပေးသူ',
                'ne' => 'द्वारा बप्तिस्मा'
            ],

            'baptized_people' => [
                'en' => 'Baptized People',
                'mm' => 'နှစ်ခြင်းပေးထားသူများ',
                'ne' => 'बप्तिस्मा भएका मानिसहरू'
            ],

            'add' => [
                'en' => 'Add',
                'mm' => 'ထည့်သွင်းရန်',
                'ne' => 'थप्नुहोस्',
            ],

            'add_baptized_person' => [
                'en' => 'Add Baptized Person',
                'mm' => 'နှစ်ခြင်းပေးထားသူထည့်သွင်းပါ',
                'ne' => 'बप्तिस्मा प्राप्त व्यक्ति थप्नुहोस्'
            ],

            'track_and_manage_ongoing_prayer_requests_or_intentions_here' => [
                'en' => 'Track and manage ongoing prayer requests or intentions here',
                'mm' => 'လက်ရှိဆုတောင်းချက်များ သို့မဟုတ် ရည်ရွယ်ချက်များကို ဤနေရာတွင် ခြေရာခံပြီး စီမံပါ။',
                'ne' => 'यहाँ चलिरहेका प्रार्थना अनुरोधहरू वा मनसायहरू ट्र्याक र व्यवस्थापन गर्नुहोस्'
            ],

            'enter_current_prayers' => [
                'en' => 'Enter current prayers',
                'mm' => 'လက်ရှိဆုတောင်းချက်များထည့်သွင်းပါ',
                'ne' => 'हालको प्रार्थनाहरू प्रविष्ट गर्नुहोस्',
            ],

            'create_and_create_another' => [
                'en' => 'Create and Create Another',
                'mm' => 'ဖန်တီးပြီး နောက်တစ်ခု ဖန်တီးပါ။',
                'ne' => 'अर्को सिर्जना गर्नुहोस् र सिर्जना गर्नुहोस्'
            ],

            'create_contact' => [
                'en' => 'Create Contact',
                'mm' => 'အဆက်အသွယ်ဖန်တီး',
                'ne' =>  'सम्पर्क सिर्जना गर्नुहोस्',
            ],

            // Filters & search 
            'all' => [
                'en' => 'All',
                'mm' => 'အားလုံး',
                'ne' => 'सबै'
            ],
            'active' => [
                'en' => 'Active',
                'mm' => 'လက်ရှိ',
                'ne' => 'सक्रिय'
            ],
            'active_up' => [
                'en' => 'ACTIVE',
                'mm' => 'လက်ရှိ',
                'ne' => 'सक्रिय'
            ],
            'inactive_up' => [
                'en' => 'INACTIVE',
                'mm' => 'အသက်မဝင်သော',
                'ne' => 'निष्क्रिय'
            ],
            'paused' => [
                'en' => 'Paused',
                'mm' => 'ရပ်ထားသော',
                'ne' => 'रोकियो',
            ],
            'archived' => [
                'en' => 'Archived',
                'mm' => 'ခွဲထားသော',
                'ne' => 'अभिलेख राखिएको'
            ],
            'new_contact' => [
                'en' => 'New Contact',
                'mm' => 'အဆက်အသွယ်အသစ်',
                'ne' => 'नयाँ सम्पर्क'
            ],
            'not_ready' => [
                'en' => 'Not Ready',
                'mm' => 'အဆင်သင့်မဖြစ်သေးသော',
                'ne' => 'तयार छैन'
            ],
            'search_in' => [
                'en' => 'Search in',
                'mm' => 'ရှာဖွေပါ',
                'ne' => 'मा खोज्नुहोस्'
            ],
            'by' => [
                'en' => 'by',
                'mm' => 'ဖြင့်',
                'ne' => 'द्वारा'
            ],

            // prayer page
            'planted_churches_prayers' => [
                'en' => 'Planted Churches Prayers',
                'mm' => 'ရှိပြီးသောာ ဘုရားကျောင်းဆုတောင်းသူများ',
                'ne' =>  'रोपिएका चर्चहरू प्रार्थनाहरू'
            ],
            'assigned_churches_prayers' => [
                'en' => 'Assigned Churches Prayers',
                'mm' => 'စာရင်းသွင်းပြီးသော ဘုရားကျောင်းဆုတောင်းသူများ',
                'ne' => 'तोकिएका चर्च प्रार्थनाहरू'
            ],
            'assigned_contacts_prayers' => [
                'en' => 'Assigned Contacts Prayers',
                'mm' => 'စာရင်းသွင်းပြီးသော အဆက်အသွယ်ဆုတောင်းသူများ',
                'ne' => 'तोकिएका सम्पर्क प्रार्थनाहरू'
            ],

            // Contact Page
            'starting_church' => [
                'en' => 'Starting Church',
                'mm' => 'ဘုရားကျောင်း စတင်ထူထောင်ခြင်း',
                'ne' => 'चर्च सुरु गर्दै'
            ],
            'in_church' => [
                'en' => 'In Church',
                'mm' => 'ဘုရားကျောင်းတွင်း',
                'ne' => 'चर्च मा'
            ],
            'group' => [
                'en' => 'Group',
                'mm' => 'အစုအဖွဲ့',
                'ne' => 'समूह'
            ],
            'baptizing' => [
                'en' => 'Baptizing',
                'mm' => 'နှစ်ခြင်းခံယူခြင်း',
                'ne' => 'बप्तिस्मा गर्दै'
            ],
            'can_share_gospel' => [
                'en' => 'Can Share Gospel',
                'mm' => 'သာသနာဖြန့်ဝေခြင်း',
                'ne' => 'सुसमाचार साझा गर्न सक्नुहुन्छ'
            ],
            'states_belief' => [
                'en' => 'State Belief',
                'mm' => 'ယုံကြည်သူ',
                'ne' => 'राज्य विश्वास'
            ],
            'reading_bible' => [
                'en' => 'Reading Bible',
                'mm' => 'ကျမ်းစာဖတ်ခြင်း',
                'ne' => 'बाइबल पढ्दै'
            ],
            'has_bible' => [
                'en' => 'Has Bible',
                'mm' => 'ကျမ်းစာရှိခြင်း',
                'ne' => 'बाइबल छ'
            ],
            'created_at' => [
                'en' => 'Created At',
                'mm' => 'ဖန်တီးခဲ့ချိန်',
                'ne' => 'मा सिर्जना गरियो'
            ],
            'updated_at' => [
                'en' => 'Updated At',
                'mm' =>  'ပြင်ဆင််ခဲ့ချိန်',
                'ne' => 'मा अद्यावधिक गरियो'
            ],
            'deleted_at' => [
                'en' => 'Deleted At',
                'mm' =>  'ဖျက်ခဲ့ချိန်',
                'ne' => 'मा मेटियो'
            ],
            'contact_platforms' => [
                'en' => 'Contact Platforms',
                'mm' =>  'အဆက်အသွယ် ပလက်ဖောင်း',
                'ne' => 'सम्पर्क प्लेटफार्महरू'
            ],
            'other_social_links' => [
                'en' => 'Other Social Links',
                'mm' =>  'အခြားလှူမှုနက်ဝက်များ',
                'ne' => 'अन्य सामाजिक लिङ्कहरू',
            ],
            'edit_contact' => [
                'en' => 'Edit Contact',
                'mm' =>  'အဆက်အသွယ် ပြင်ဆင်ခြင်း',
                'ne' => 'सम्पर्क सम्पादन गर्नुहोस्',
            ],

            // Churches Page
            'description' => [
                'en' => 'Description',
                'mm' => 'အသေးစိတ်အချက်အလက်',
                'ne' => 'विवरण'
            ],
            'church.need_to_change' => [
                'en' => 'Church.Need to change',
                'mm' => 'ပြင်ဆင်ရန်လိုသော ဘုရားကျောင်း',
                'ne' => 'चर्च। परिवर्तन आवश्यक छ'
            ],
            'church_members_count' => [
                'en' =>  'Church members Count',
                'mm' => 'ဘုရားကျောင်းအဖွဲ့ဝင် အရေအတွက်',
                'ne' => 'चर्चका सदस्यहरूको संख्या'
            ],
            'this_denomination_is_in_trash' => [
                'en' => 'This denomination is in trash.',
                'mm' => 'ဒီဂိုဏ်းခွဲက ဖျက်သိမ်းထားသည့်အထဲ ရောက်နေသည်',
                'ne' => 'यो सम्प्रदाय रद्दीको टोकरीमा छ।'
            ],
            'select_a_parent_church_if_any' => [
                'en' => 'Select a parent church if any',
                'mm' => 'မိခင်ဘုရားကျောင်းရှိရင် ရွေးချယ်ပါ',
                'ne' => 'यदि कुनै अभिभावक चर्च छ भने छान्नुहोस्।'
            ],
            'is_active' => [
                'en' => 'Is Active',
                'mm' =>  'အသက်ဝင်သည်',
                'ne' => 'सक्रिय छ'
            ],
            'no_church_planters' => [
                'en' => 'No Church Planters',
                'mm' =>  'ဘုရားကျောင်း တည်ထောင်သူမရှိ',
                'ne' => 'कुनै चर्च प्लान्टहरू छैनन्'
            ],
            'church_planters' => [
                'en' => 'Church Planters',
                'mm' => 'ဘုရားကျောင်းတည်ထောင်သူများ',
                'ne' => 'चर्च प्लान्टर्स'
            ],
            'search_church_planters_by_name' => [
                'en' => 'Search Church Planters By Name',
                'mm' => 'ဘုရားကျောင်းတည်ထောင်သူများကို နာမည်ဖြင့် ရှာဖွေပါ',
                'ne' => 'नाम अनुसार चर्च प्लान्टरहरू खोज्नुहोस्'
            ],
            'add_church_planter' => [
                'en' => 'Add Church Planter',
                'mm' => 'ဘုရားကျောင်းတည်ထောင်သူကိုထည့်ပါ',
                'ne' => 'चर्च प्लाटर थप्नुहोस्'
            ],
            'church_name' =>  [
                'en' => 'Church Name',
                'mm' =>  'ဘုရားကျောင်း နာမည်',
                'ne' => 'चर्चको नाम'
            ],
            'parent_church' => [
                'en' => 'Parent Church',
                'mm' =>  'မိခင် ဘုရားကျောင်း',
                'ne' => 'अभिभावक चर्च'
            ],
            'denomination' => [
                'en' => 'Denomination',
                'mm' =>  'ဂိုဏ်းခွဲ',
                'ne' => 'सम्प्रदाय'
            ],
            'denominations' => [
                'en' => 'Denominations',
                'mm' => 'ဂိုဏ်းခွဲများ',
                'ne' => 'धुने पाउडर, प्लेट धुने र टिस्युज'
            ],
            'church_member_count' => [
                'en' => 'Church Members Count',
                'mm' =>  'ဘုရားကျောင်း အဖွဲ့အဝင် အရေအတွက်',
                'ne' => 'चर्च सदस्यहरू गणना'
            ],
            'church_website' => [
                'en' => 'Church Website',
                'mm' => 'ဘုရားကျောင်း ဝက်ဆိုဒ်',
                'ne' => 'चर्च वेबसाइट'
            ],
            'enter_church_website' => [
                'en' => 'Enter Church Website',
                'mm' => 'ဘုရားကျောင်း ဝက်ဆိုဒ်ထည့်ပါ',
                'ne' => 'चर्च वेबसाइट प्रविष्ट गर्नुहोस्'
            ],
            'select_a_date' => [
                'en' => 'Select a date',
                'mm' => 'နေ့ရက်တစ်ခုကို ရွေးချယ်ပါ။',
                'ne' => 'मिति चयन गर्नुहोस्'
            ],
            'select_a_church_denomination' => [
                'en' => 'Select a church denomination',
                'mm' => 'ဘုရားကျောင်း ဂိုဏ်းခွဲတစ်ခုကိုရွေးပါ',
                'ne' => 'चर्च सम्प्रदाय छान्नुहोस्'
            ],
            'church_phone_number' => [
                'en' => 'Church Phone Number',
                'mm' =>  'ဘုရားကျောင်း ဖုန်းနံပါတ်',
                'ne' => 'चर्च फोन नम्बर'
            ],
            'enter_church_phone_number' => [
                'en' => 'Enter Church Phone Number',
                'mm' => 'ဘုရားကျောင်းဖုန်းနံပါတ်ထည့်ပါ',
                'ne' => 'चर्चको फोन नम्बर प्रविष्ट गर्नुहोस्',
            ],
            'confession_of_faith_count' => [
                'en' => 'Confession of Faith Count',
                'mm' =>  'ယုံကြည်သူ‌ အရေအတွက်',
                'ne' => 'विश्वास गणनाको स्वीकारोक्ति'
            ],
            'founded_at' => [
                'en' => 'Founded At',
                'mm' =>  'တည်ထောင်ခဲ့ချိန်',
                'ne' => 'मा स्थापना भयो'
            ],
            'is_visited' => [
                'en' => 'Is Visited',
                'mm' =>  'လည်ပတ်ခဲ့ချိန်',
                'ne' => 'भ्रमण गरिएको छ'
            ],
            'baptized_count' => [
                'en' => 'Baptized Count',
                'mm' =>  'နှစ်ခြင်းပေးသူ အရေအတွက်',
                'ne' => 'बप्तिस्मा गणना'
            ],
            'enter_church_name' => [
                'en' => 'Enter church Name',
                'mm' =>  'ဘုရားကျောင်း နာမည်ဖြည့်ပါ',
                'ne' => 'चर्चको नाम प्रविष्ट गर्नुहोस्'
            ],
            'please_input' => [
                'en' => 'Please Input',
                'mm' =>  'ကျေးဇူးပြု၍ ဖြည့်ပါ',
                'ne' => 'कृपया इनपुट गर्नुहोस्'
            ],
            'please_select' => [
                'en' => 'Please Select',
                'mm' =>  'ကျေးဇူးပြု၍ ရွေးချယ်ပါ',
                'ne' => 'कृपया चयन गर्नुहोस्'
            ],
            'this_community_is_in_trash' => [
                'en' => 'This community is in trash.',
                'mm' => 'ဒီအဖွဲ့အစည်းသည် ဖျက်သိမ်းထားသည့်အထဲ ရောက်နေသည်',
                'ne' => 'यो समुदाय फोहोरमा छ।'
            ],
            'conducted_survey_of_community_needs' => [
                'en' => 'Conducted Survey of Community Needs',
                'mm' => 'အဖွဲ့အစည်းလိုအပ်ချက်များကို စစ်တမ်းကောက်ယူခြင်း',
                'ne' => 'समुदायको आवश्यकताको सर्वेक्षण गरियो'
            ],
            'longitude' => [
                'en' => 'Longitude',
                'mm' =>  'လောင်ဂျီကျု',
                'ne' => 'देशान्तर'
            ],
            'latitude' => [
                'en' => 'Latitude',
                'mm' =>  'လတ္တီကျု',
                'ne' => 'अक्षांश'
            ],
            'person_of_peace' => [
                'en' => 'Person Of Peace',
                'mm' =>  'ငြိမ်းချမ်းသူ',
                'ne' => 'शान्ति को व्यक्ति'
            ],
            'no_person_of_peace' => [
                'en' => 'No Person of Peace',
                'mm' =>  'ငြိမ်းချမ်းသူမရှိပါ',
                'ne' => 'शान्तिको व्यक्ति छैन'
            ],
            'add_person_of_peace' => [
                'en' => 'Add Person of Peace',
                'mm' =>  'ငြိမ်းချမ်းသူ ဖြည့်ပါ',
                'ne' => 'शान्तिको व्यक्ति थप्नुहोस्'
            ],
            'committees' => [
                'en' => 'Committees',
                'mm' =>  'ကော်မတီ',
                'ne' => 'समितिहरू'
            ],
            'no_community_committees' => [
                'en' => 'No Community Committees',
                'mm' =>  'အဖွဲ့အစည်း ကော်မတီမရှိ',
                'ne' => 'सामुदायिक समितिहरू छैनन्'
            ],
            'add_community_committees' => [
                'en' => 'Add Community Committees',
                'mm' =>  'အဖွဲ့အစည်း ကော်မတီထည့်ရန်',
                'ne' => 'सामुदायिक समितिहरू थप्नुहोस्'
            ],
            'community_committees' => [
                'en' => 'Community Committees',
                'mm' => 'အဖွဲ့အစည်းကော်မတီ',
                'ne' => 'सामुदायिक समितिहरू'
            ],
            'add_community_committee' => [
                'en' => 'Add Community Committee',
                'mm' =>  'အဖွဲ့အစည်း ကော်မတီထည့်ရန်',
                'ne' => 'सामुदायिक समितिहरू थप्नुहोस्'
            ],
            'community_committee' => [
                'en' => 'Community Committee',
                'mm' => 'အဖွဲ့အစည်းကော်မတီ',
                'ne' => 'सामुदायिक समितिहरू'
            ],
            'community_needs' => [
                'en' => 'Community Needs',
                'mm' =>  'အဖွဲ့အစည်း လိုအပ်ချက်',
                'ne' => 'सामुदायिक आवश्यकताहरू'
            ],

            // Profile
            'input_name' => [
                'en' => 'Input Name',
                'mm' => 'နာမည်ဖြည့်ပါ',
                'ne' => 'इनपुट नाम'
            ],
            'username' => [
                'en' => 'Username',
                'mm' =>  'အသုံးပြုသူနာမည်',
                'ne' => 'प्रयोगकर्ता नाम'
            ],
            'input_username' => [
                'en' => 'Input Username',
                'mm' => 'အသုံးပြုသူနာမည်ထည့်ပါ',
                'ne' => 'इनपुट प्रयोगकर्ता नाम',
            ],
            'email' => [
                'en' => 'Email',
                'mm' => 'အီးမေးလ်',
                'ne' => 'इमेल',
            ],
            'phone' => [
                'en' => 'Phone',
                'mm' => 'ဖုန်း',
                'ne' => 'फोन'
            ],
            'email_address' => [
                'en' =>  'Email Address',
                'mm' =>  'အီးမေးလိပ်စာ',
                'ne' => 'इमेल ठेगाना'
            ],
            'input_email_address' => [
                'en' => 'Input Email Address',
                'mm' => 'အီးမေးလိပ်စာထည့်ပါ',
                'ne' => 'इमेल ठेगाना इनपुट गर्नुहोस्'
            ],

            'phone_number' => [
                'en' => 'Phone Number',
                'mm' =>  'ဖုန်းနံပါတ်',
                'ne' => 'फोन नम्बर'
            ],
            'input_phone_number' => [
                'en' => 'Input Phone Number',
                'mm' => 'ဖုန်းနံပါတ်ထည့်ပါ',
                'ne' => 'इनपुट फोन नम्बर'
            ],
            'biography' => [
                'en' => 'Biography',
                'mm' =>  'ကိုယ်ရေးအကျဉ်း',
                'ne' => 'जीवनी'
            ],
            'input_biography' =>  [
                'en' => 'Input Biography',
                'mm' =>  'ကိုယ်ရေးအကျည်းထည့်ပါ',
                'ne' => 'इनपुट जीवनी'
            ],
            'preferred_language' => [
                'en' => 'Preferred Language',
                'mm' =>  'ဘာသာစကားရွေးရန်',
                'ne' => 'रुचाइएको भाषा'
            ],

            'select_preferred_language' =>  [
                'en' =>  'Select Preferred Language',
                'mm' => 'နှစ်သက်ရာဘာသာစကားရွေးရန်',
                'ne' => 'मनपर्ने भाषा चयन गर्नुहोस्'
            ],

            // Dashboard
            'under_construction' => [
                'en' => 'Under Construction',
                'mm' =>  'တည်ဆောာက်ဆဲ',
                'ne' => 'निर्माणाधीन'
            ],

            // Settings 
            'manage_user_roles' => [
                'en' => 'Manage User Roles',
                'mm' =>  'အသုံးပြုသူအခန်းကဏ္ဍစီမံခြင်း',
                'ne' => 'प्रयोगकर्ता भूमिकाहरू प्रबन्ध गर्नुहोस्'
            ],
            'role' => [
                'en' => 'role',
                'mm' =>  'အခန်းကဏ္ဍ',
                'ne' => 'भूमिका'
            ],
            'guest' => [
                'en' => 'Guest',
                'mm' =>  'ဧည်သည့်',
                'ne' => 'अतिथि'
            ],
            'church_planter' => [
                'en' => 'Church Planter',
                'mm' =>  'ဘုရားကျောင်းတည်ထောင်သူ',
                'ne' => 'चर्च प्लाटर'
            ],
            'administrator' => [
                'en' => 'Administrator',
                'mm' =>  'စီမံခွဲသူ',
                'ne' => 'प्रशासक'
            ],
            'administrators' => [
                'en' =>  'Administrators',
                'mm' => 'စီမံခန့်ခွဲသူများ',
                'ne' => 'प्रशासकहरू'
            ],
            'developer' => [
                'en' => 'Developer',
                'mm' =>  'ဖန်တီးသူ',
                'ne' => 'विकासकर्ता'
            ],
            'super_admin' => [
                'en' => 'Super Admin',
                'mm' =>  'စူပါစီမံခန့်ခွဲသူ',
                'ne' =>  'सुपर एडमिन'
            ],
            'denomination.need_to_change' => [
                'en' => 'Denomination. Need to change',
                'mm' => 'ပြင်ဆင်ရန်လိုသော ဂိုဏ်းခွဲ',
                'ne' => 'सम्प्रदाय। परिवर्तन आवश्यक छ'
            ],
            'people_group.need_to_change' => [
                'en' => 'People Group. Need to Change',
                'mm' => 'ပြင်ဆင်ရန်လိုသော လူမျိုးအုပ်စု',
                'ne' => 'मानिसहरूको समूह। परिवर्तन आवश्यक छ'
            ],
            'icon' => [
                'en' => 'Icon',
                'mm' => 'အမှတ်တံဆိပ်',
                'ne' => 'आइकन'
            ],
            'change_icon' => [
                'en' => 'Change Icon',
                'mm' => 'အမှတ်တံဆိပ်ပြောင်းလဲရန်',
                'ne' => 'आइकन परिवर्तन गर्नुहोस्'
            ],
            'upload_icon' => [
                'en' => 'Upload Icon',
                'mm' => 'အမှတ်တံဆိပ် ထည့်ရန်',
                'ne' => 'अपलोड आइकन'
            ],
            'this_people_group_is_in_trash' => [
                'en' => 'This people group is in trash.',
                'mm' => 'ဒီလူမျိုးအုပ်စုသည် ဖျက်သိမ်းထားသည့်အထဲ ရောက်နေသည်',
                'ne' => 'यो समूह रद्दीको टोकरीमा छ।'
            ],
            'community_checklist.need_to_change' => [
                'en' => 'Community Checklist.Need to change',
                'mm' => 'ပြင်ဆင်ရန်လိုသော အဖွဲ့အစည်းမှတ်စုများ',
                'ne' => 'समुदाय चेकलिस्ट। परिवर्तन गर्न आवश्यक छ'
            ],
            'this_community_checklist_is_in_trash' => [
                'en' => 'This community checklist is in trash.',
                'mm' => 'ဒီအဖွဲ့အစည်းမှတ်စုသည် ဖျက်သိမ်းထားသည့်အထဲရောက်နေသည်',
                'ne' => 'यो समुदाय चेकलिस्ट रद्दीको टोकरीमा छ।'
            ],
            'manage_system_languages' => [
                'en' => 'Manage System Languages',
                'mm' => 'ဘာသာစကားများ စီမံခြင်း',
                'ne' => 'प्रणाली भाषाहरू व्यवस्थापन गर्नुहोस्'
            ],
            'select_language' => [
                'en' => 'Select Language',
                'mm' => 'ဘာသာစကားတစ်ခုရွေးချယ်ပါ',
                'ne' => 'भाषा छनोट गर्नुस'
            ],
            'search_word' => [
                'en' => 'Search Word',
                'mm' => 'စကားလုံးရှာဖွေရန်',
                'ne' => 'शब्द खोज्नुहोस्'
            ],
            'create_word' => [
                'en' => 'Create Word',
                'mm' => 'စကားလုံးဖန်တီးရန်',
                'ne' => 'शब्द सिर्जना गर्नुहोस्'
            ],
            'input_a_translated_word' => [
                'en' => 'Input a translated word',
                'mm' => 'ဘာသာပြန်ထားသော စကားလုံးထည့်ပါ',
                'ne' => 'अनुवादित शब्द इनपुट गर्नुहोस्'
            ],
            'manage_communication_platforms' => [
                'en' => 'Manage Communication Platforms',
                'mm' => 'အဖွဲ့အစည်းပလက်ဖောင်းအား စီမံခြင်း',
                'ne' => 'सञ्चार प्लेटफर्महरू प्रबन्ध गर्नुहोस्'
            ],
            'manage_faith_milestones' => [
                'en' => 'Manage Faith Milestones',
                'mm' => 'ယုံကြည်ခြင်းမှတ်တိုင်များအား စီမံခြင်း',
                'ne' => 'विश्वास माइलस्टोनहरू प्रबन्ध गर्नुहोस्'
            ],
            'manage_people_groups' => [
                'en' => 'Manage People Groups',
                'mm' => 'လူမျိုးစုများအား စီမံခြင်း',
                'ne' => 'व्यक्ति समूहहरू प्रबन्ध गर्नुहोस्'
            ],
            'manage_denominations' => [
                'en' => 'Manage Denominations',
                'mm' => 'ဂိုဏ်းခွဲများအား စီမံခြင်း',
                'ne' => 'सम्प्रदायहरू व्यवस्थापन गर्नुहोस्'
            ],
            'manage_community_checklist' => [
                'en' => 'Manage Community Checklist',
                'mm' => 'အဖွဲ့အစည်းမှတ်တမ်းများအား စီမံခြင်း',
                'ne' => 'सामुदायिक चेकलिस्ट प्रबन्ध गर्नुहोस्'
            ],
            'name_is_required' => [
                'en' => 'Name is required',
                'mm' => 'နာမည်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'नाम आवश्यक छ'
            ],
            'label_is_required' => [
                'en' => 'Label is required',
                'mm' => 'လေဘယ်ထည့်ရန် လိုအအပ်သည်',
                'ne' => 'लेबल आवश्यक छ'
            ],
            'the_name_field_is_required' => [
                'en' => 'The name field is required',
                'mm' => 'နာမည်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'नाम क्षेत्र आवश्यक छ।'
            ],
            'community_is_required' => [
                'en' => 'Community is required',
                'mm' => 'အဖွဲ့အစည်းထည့်ရန် လိုအပ်သည်',
                'ne' => 'समुदाय आवश्यक छ'
            ],
            'the_gender_field_is_required' => [
                'en' => 'The gender field is required',
                'mm' => 'လိင်အမျိုးအစားထည့်ရန် လိုအပ်သည်',
                'ne' => 'लिङ्ग क्षेत्र आवश्यक छ'
            ],
            'the_age_field_is_required' => [
                'en' => 'The age field is required.',
                'mm' => 'အသက်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'उमेर क्षेत्र आवश्यक छ।'
            ],
            'the_label_field_is_required' => [
                'en' => 'The label field is required.',
                'mm' => 'လေဘယ်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'लेबल क्षेत्र आवश्यक छ।'
            ],
            'the_username_field_is_required' => [
                'en' => 'The username field is required.',
                'mm' => 'အသုံးပြုသူနာမည်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'प्रयोगकर्ता नाम क्षेत्र आवश्यक छ।'
            ],
            'the_email_field_is_required' => [
                'en' => 'The email field is required.',
                'mm' => 'အီးမေလ်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'इमेल क्षेत्र आवश्यक छ।'
            ],
            'the_is_active_field_is_required' => [
                'en' => 'The Is Active field is required.',
                'mm' => 'အသက်ရှိမရှိ ထည့်ရန်လိုအပ်သည်',
                'ne' => '"सक्रिय छ" फिल्ड आवश्यक छ।'
            ],
            'the_user_role_id_field_is_required' => [
                'en' => 'The user role is required',
                'mm' => 'အသုံးပြုသူ အခန်းကဏ္ဍထည့်ရန် လိုအပ်သည်',
                'ne' => 'प्रयोगकर्ता भूमिका आवश्यक छ'
            ],
            'the_preferred_language_id_field_is_required' => [
                'en' => 'The preferred langauge field is required.',
                'mm' => 'နှစ်သက်ရာဘာသာစကားကို ရွေးချယ်ရန်လိုအပ်သည်',
                'ne' => 'रुचाइएको भाषा क्षेत्र आवश्यक छ।'
            ],
            'username_is_required' => [
                'en' => 'Username is required',
                'mm' => 'အသုံးပြုသူနာမည် လိုအပ်သည်',
                'ne' => 'प्रयोगकर्ता नाम आवश्यक छ'
            ],
            'password_is_required' => [
                'en' => 'Password is required',
                'mm' => 'စကားဝှက်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'पासवर्ड आवश्यक छ'
            ],
            'password_must_be_at_least_8_characters' => [
                'en' => 'Password must be at least 8 characters',
                'mm' => 'စကားဝှက်သည် အနည်းဆုံး စကားလုံးရှစ်လုံးပါရန် လိုအပ်သည်',
                'ne' => 'पासवर्ड कम्तिमा ८ वर्णको हुनुपर्छ।'
            ],
            'gender_needs_to_be_specified' => [
                'en' => 'Gender needs to be specified.',
                'mm' => 'လိင်အမျိုးအစား သတ်မှတ်ရန်လိုအပ်သည်',
                'ne' => 'लिङ्ग निर्दिष्ट गर्न आवश्यक छ।'
            ],
            'age_needs_to_be_specified' => [
                'en' => 'Age needs to be specified.',
                'mm' => 'အသက်သတ်မှတ်ရန် လိုအပ်သည်',
                'ne' => 'उमेर तोक्नु आवश्यक छ।'
            ],
            'longitude_is_required' => [
                'en' => 'Longitude is required',
                'mm' => 'လောင်ဂျီကျုထည့်ရန် လိုအပ်သည်',
                'ne' => 'देशान्तर आवश्यक छ'
            ],
            'latitude_is_required' => [
                'en' => 'Latitude is required',
                'mm' => 'လတ္တီကျုထည့်ရန် လိုအပ်သည်',
                'ne' => 'अक्षांश आवश्यक छ'
            ],
            'icon_is_required' => [
                'en' => 'Icon is required',
                'mm' => 'အမှတ်တံဆိပ်ထည့်ရန် လိုအပ်သည်',
                'ne' => 'आइकन आवश्यक छ'
            ],
            'planted_churches_prayers' => [
                'en' => 'Planted Churches\' Prayers',
                'mm' => 'တည်ထောင်ထားသောဘုရားကျောင်းများရှိ ဆုတောင်းသူများ',
                'ne' => 'रोपिएका चर्चहरूको प्रार्थना',
            ],
            'assigned_churches_prayers' => [
                'en' => 'Assigned Churches\' Prayers',
                'mm' => 'စာရင်းသွင်းထားသော ဘုရားကျောင်းများရှိ ဆုတောင်းသူများ',
                'ne' => 'तोकिएका चर्चहरूको प्रार्थना',
            ],
            'assigned_contacts_prayers' => [
                'en' => 'Assigned Contacts\' Prayers',
                'mm' => 'စာရင်းသွင်းထားသော အဆက်အသွယ်ဆုတောင်းသူများ',
                'ne' => 'तोकिएका सम्पर्कहरूको प्रार्थना'
            ],
            'something_went_wrong' => [
                'en' => 'Aiyo! Something went wrong.',
                'mm' => 'တစ်ခုခုမှားနေသည်',
                'ne' => 'केहि गलत भयो।'
            ],
            'welcome_back' => [
                'en' => 'Welcome back',
                'mm' => 'ပြန်လည်ကြိုဆိုပါတယ်',
                'ne' => 'स्वागत छ।'
            ],
            'exit_trashed_view' => [
                'en' => 'Exit Trashed View',
                'mm' => 'အမှိုက်ပုံးမြင်ကွင်းမှ ထွက်ပါ',
                'ne' => 'रद्दीको टोकरी दृश्यबाट बाहिर निस्कनुहोस्'
            ],
            'view_trashed_item' => [
                'en' => 'View Trashed Items',
                'mm' => 'အမှိုက်ပုံးထဲသို့ ကြည့်ရန်',
                'ne' => 'रद्दीटोकरीमा राखिएका वस्तुहरू हेर्नुहोस्'
            ],
            'the_community_id_field_is_required' => [
                'en' => 'The community field is required.',
                'mm' => 'အဖွဲ့အစည်းထည့်ရန်လိုအပ်သည်',
                'ne' => 'सामुदायिक क्षेत्र आवश्यक छ।'
            ],
            'seeker' => [
                'en' => 'Seeker',
                'mm' => 'ရှာဖွေသူ',
                'ne' => 'खोजीकर्ता'
            ],
            'believer' => [
                'en' => 'Believer',
                'mm' => 'ယုံကြည်သူ',
                'ne' => 'विश्वासी'
            ],
            'leader' => [
                'en' => 'Leader',
                'mm' => 'ဦးဆောင်သူ',
                'ne' => 'नेता'
            ],
            'authentication' => [
                'en' => 'Authentication',
                'mm' => 'စစ်မှန်ကြောင်းအထောက်အထား',
                'ne' => 'प्रमाणीकरण'
            ],
            'create_contacts' => [
                'en' => 'Create Contact',
                'mm' => 'အဆက်အသွယ်ဖန်တီး',
                'ne' =>  'सम्पर्क सिर्जना गर्नुहोस्',
            ],
            'create_churches' => [
                'en' => 'Create Church',
                'mm' => 'ဘုရားကျောင်းဖန်တီး',
                'ne' => 'चर्च सिर्जना गर्नुहोस्'
            ],
            'create_communities' => [
                'en' => 'Create Communities',
                'mm' => 'အသိုင်းအဝိုင်းဖန်တီး',
                'ne' => 'समुदायहरू सिर्जना गर्नुहोस्'
            ],
            'edit_contacts' => [
                'en' => 'Edit Contact',
                'mm' => 'အဆက်အသွယ်ပြင်ဆင်',
                'ne' => 'सम्पर्क सम्पादन गर्नुहोस्'
            ],
            'edit_churches' => [
                'en' => 'Edit Church',
                'mm' => 'ဘုရားကျောင်းပြင်ဆင်',
                'ne' => 'चर्च सम्पादन गर्नुहोस्'
            ],
            'edit_communities' => [
                'en' => 'Edit Community',
                'mm' => 'အဖွဲ့အစည်းပြင်ဆင်',
                'ne' => 'समुदाय सम्पादन गर्नुहोस्'
            ],
            'search_contacts_by_name' => [
                'en' => 'Search contacts by name',
                'mm' => 'အဆက်အသွယ်များကို အမည်ဖြင့်ရှာဖွေပါ',
                'ne' => 'नामद्वारा सम्पर्कहरू खोज्नुहोस्'
            ],
            'search_communities_by_name' => [
                'en' => 'Search communities by name',
                'mm' => 'အဖွဲ့အစည်းများကို အမည်ဖြင့်ရှာဖွေပါ',
                'ne' => 'नामद्वारा समुदायहरू खोज्नुहोस्'
            ],
            'search_churches_by_name' => [
                'en' => 'Search churches by name',
                'mm' => 'ဘုရားကျောင်းများကို အမည်ဖြင့်ရှာဖွေပါ',
                'ne' => 'नामद्वारा चर्चहरू खोज्नुहोस्'
            ],
            'venture_tools' => [
                'en' => 'Venture Tools',
                'mm' => 'ဗန်းချားတူး',
                'ne' => 'उद्यम उपकरणहरू'
            ],
            'security' => [
                'en' => 'Security',
                'mm' => 'လုံခြုံရေး',
                'ne' => 'सुरक्षा'
            ],
            'pin_number' => [
                'en' => 'Pin Number',
                'mm' => 'ပင်နံပါတ်',
                'ne' => 'पिन नम्बर'
            ],
            'application_mask' => [
                'en' => 'Application Mask',
                'mm' => 'မျက်နှာဖုံး',
                'ne' => 'अनुप्रयोग मास्क'
            ],
            'enter_your_pin_number' => [
                'en' => 'Enter your pin number',
                'mm' => 'ပင်နံပါတ်ထည့်ပါ',
                'ne' => 'आफ्नो पिन नम्बर प्रविष्ट गर्नुहोस्'
            ],
            'confirm_your_pin_number' => [
                'en' => 'Confirm your pin number',
                'mm' => 'ပင်နံပါတ်ကို အတည်ပြုပါ',
                'ne' => 'आफ्नो पिन नम्बर पुष्टि गर्नुहोस्'
            ],
            'no_trashed_church_found' => [
                'en' =>  'No trashed church found',
                'mm' => 'ဖျက်ထားသော ဘုရားကျောင်းမရှိပါ',
                'ne' => 'फोहोर फालिएका चर्चहरू भेटिएनन्'
            ],
            'no_trashed_contact_found' => [
                'en' =>  'No trashed contact found',
                'mm' => 'ဖျက်ထားသော အဆက်အသွယ်မရှိပါ',
                'ne' => 'रद्दीको टोकरीमा हालिएको कुनै सम्पर्क भेटिएन'
            ],
            'no_trashed_community_found' => [
                'en' => 'No trashed community found',
                'mm' =>  'ဖျက်ထားသော အသိုင်းအဝိုင်းမရှိပါ',
                'ne' => 'रद्दीटोकरीमा हालिएको कुनै समुदाय भेटिएन'
            ],
            'choose_contact_status' => [
                'en' => 'Choose contact status',
                'mm' => 'အဆက်အသွယ်အခြေအနေကို ရွေးပါ',
                'ne' => 'सम्पर्क स्थिति छनौट गर्नुहोस्'
            ],
            'title' => [
                'en' =>  'Title',
                'mm' => 'ခေါင်းစဉ်',
                'ne' => 'शीर्षक'
            ],
            'choose_faith_status' => [
                'en' => 'Choose Faith Status',
                'mm' => 'ယုံကြည်ခြင်းအခြေအနေကို ရွေးချယ်ပါ',
                'ne' => 'विश्वास स्थिति छनौट गर्नुहोस्'
            ],
            'statuses' => [
                'en' =>  'Statuses',
                'mm' => 'အခြေအနေများ',
                'ne' => 'स्थितिहरू'
            ],
            'general_infromation' => [
                'en' => 'General Information',
                'mm' => 'အထွေထွေ အချက်အလက်',
                'ne' => 'सामान्य जानकारी'
            ],
            'choose_people_group' => [
                'en' => 'Choose people group',
                'mm' => 'လူမျိုးအုပ်စုကို  ရွေးပါ',
                'ne' => 'मान्छेहरूको समूह छान्नुहोस्'
            ],
            'choose_faith_milestones' => [
                'en' => 'Choose faith milestones',
                'mm' => 'ယုံကြည်ခြင်းမှတ်တိုင်များကို ရွေးချယ်ပါ',
                'ne' => 'विश्वासका कोसेढुङ्गाहरू छनौट गर्नुहोस्'

            ],
            'choose_baptized_by' => [
                'en' => 'Choose baptized by',
                'mm' => 'နှစ်ခြင်းပေးသူကို ရွေးပါ',
                'ne' =>  'द्वारा बप्तिस्मा छान्नुहोस्'
            ],
            'choose_baptism_date' => [
                'en' => 'Choose baptism date',
                'mm' => 'ဗတ္တိဇံခံယူသည့်ရက်',
                'ne' => 'बप्तिस्मा मिति छान्नुहोस्'
            ],
            'enter_name' => [
                'en' => 'Enter name',
                'mm' => 'နာမည်ထည့်ပါ',
                'ne' =>  'नाम प्रविष्ट गर्नुहोस्'
            ],
            'enter_nickname' => [
                'en' => 'Enter nickname',
                'mm' => 'အိမ်ခေါ်အမည်ထည့်ပါ',
                'ne' => 'उपनाम प्रविष्ट गर्नुहोस्'
            ],
            'enter_new_value' => [
                'en' => 'Enter new value',
                'mm' => 'တန်ဖိုးအသစ်ထည့်ပါ',
                'ne' => 'नयाँ मान प्रविष्ट गर्नुहोस्'
            ],
            'value' => [
                'en' => 'Value',
                'mm' => 'တန်ဖိုး',
                'ne' => 'मूल्य'
            ],
            'age_group' => [
                'en' => 'Age group',
                'mm' =>  'အသက်အရွယ်အုပ်စု',
                'ne' => 'उमेर समूह'
            ],
            'choose_age_group' => [
                'en' => 'Choose age group',
                'mm' => 'အသက်အရွယ်အုပ်စု ရွေးချယ်ပါ',
                'ne' => 'उमेर समूह छान्नुहोस्'
            ],
            'select_location' => [
                'en' => 'Select location',
                'mm' => 'တည်နေရာကို ရွေးချယ်ပါ',
                'ne' => 'स्थान चयन गर्नुहोस्'
            ],
            'submit' => [
                'en' => 'Submit',
                'mm' => 'သိမ်ဆည်းရန်',
                'ne' => 'पेश गर्नुहोस्'
            ],
            'select_community' => [
                'en' => 'Select community',
                'mm' => 'အသိုင်းအဝိုင်းရွေးချယ်ပါ',
                'ne' => 'समुदाय चयन गर्नुहोस्'
            ],
            'church_description' => [
                'en' => 'Church description',
                'mm' => 'ဘုရားကျောင်း အသေးစိတ်',
                'ne' => 'चर्चको विवरण'
            ],
            'enter_church_description' => [
                'en' => 'Enter church description',
                'mm' => 'ဘုရားကျောင်းအသေးစိတ်ထည်ပါ',
                'ne' => 'चर्च विवरण प्रविष्ट गर्नुहोस्'
            ],
            'select_parent_church' => [
                'en' => 'Select parent church',
                'mm' => 'မိခင်ဘုရားကျောင်းကို ရွေးချယ်ပါ',
                'ne' => 'अभिभावक चर्च छान्नुहोस्'
            ],
            'select_date' => [
                'en' => 'Select date',
                'mm' => 'နေ့ရက်ရွေးပါ',
                'ne' => 'मिति चयन गर्नुहोस्'
            ],
            'select_church_denomination' => [
                'en' => 'Select church denomination',
                'mm' => 'ဂိုဏ်းခွဲရွေးချယ်ပါ',
                'ne' => 'चर्च सम्प्रदाय छान्नुहोस्'
            ],
            'search_for_a_palce_here' => [
                'en' => 'Search for a place here : ',
                'mm' => 'တည်နေရာကို ရွေးချယ်ပါ : ',
                'ne' => 'यहाँ ठाउँ खोज्नुहोस् : '
            ],
            'notification' => [
                'en' => 'Notification',
                'mm' => 'အသိပေးချက်',
                'ne' => 'सूचना'
            ],
            'manage_notifications' => [
                'en' => 'Manage Notifications',
                'mm' => 'အသိပေးချက်များကို စီမံပါ',
                'ne' => 'सूचना व्यवस्थापन गर्नुहोस्'
            ],
            'status' => [
                'en' => 'Status',
                'mm' => 'အခြေအနေ',
                'ne' => 'स्थिति'
            ],
            'enable_notification' => [
                'en' => 'Enable Notification',
                'mm' => 'အသိပေးချက်ကို ဖွင့်ရန်',
                'ne' => 'सूचना सक्षम पार्नुहोस्'
            ],
            'interval' => [
                'en' => 'Interval',
                'mm' => 'အချိန်အပိုင်းအခြား',
                'ne' => 'अन्तराल'
            ],
            'how_often_should_the_notifications_be_sent' => [
                'en' => 'How often should the notifications be sent?',
                'mm' => 'အသိပေးချက်များကို ဘယ်လိုအချိန်ကို ပို့မလဲ?',
                'ne' => 'सूचनाहरू कति पटक पठाउनुपर्छ?'
            ],
            'once_every' => [
                'en' => 'Once every',
                'mm' => 'အကြိမ်',
                'ne' => 'प्रत्येक पटक'
            ],
            'please_select_unit' => [
                'en' => 'Please select unit',
                'mm' => 'အချိန်အပိုင်းအခြားကို ရွေးချယ်ပါ',
                'ne' => 'कृपया एकाइ चयन गर्नुहोस्'
            ],
            'message' => [
                'en' => 'Message',
                'mm' =>  'သတင်းစကား',
                'ne' => 'सन्देश'
            ],
            'please_enter_a_number' => [
                'en' => 'Please enter a nubmer',
                'mm' => 'နံပါတ်တစ်ခုထည့်ပါ',
                'ne' => 'कृपया नम्बर प्रविष्ट गर्नुहोस्'
            ],
            'select_day' => [
                'en' => 'Select day',
                'mm' => 'နေ့ရက်ကိုရွေးပါ',
                'ne' => 'दिन चयन गर्नुहोस्'
            ],
            'at_what_time' =>  [
                'en' => 'At what time?',
                'mm' =>  'ဘယ်အချိန်မှာ ပို့မှာလဲ',
                'ne' => 'कति बजे?'
            ],
            'hour' => [
                'en' => 'Hour',
                'mm' => 'နာရီ',
                'ne' => 'घण्टा'
            ],
            'minute' => [
                'en' => 'Minute',
                'mm' => 'မိနစ်',
                'ne' => 'मिनेट'
            ],
            'am_pm' => [
                'en' => 'AM/PM',
                'mm' => 'မနက်/ည',
                'ne' => 'बिहान/बेलुका'
            ],
            'enter_the_message_title_in_english' => [
                'en' => 'Enter the message title in English',
                'mm' => 'အသိပေးချက်ခေါင်းစဉ်ကို အင်္ဂလိပ်စာဖြင့် ဖြည့်ပါ',
                'ne' => 'सन्देशको शीर्षक अंग्रेजीमा प्रविष्ट गर्नुहोस्।'
            ],
            'enter_the_message_title_in_myanmar' => [
                'en' => 'Enter the message title in Myanamr',
                'mm' => 'အသိပေးချက်ခေါင်းစဉ်ကို မြန်မာစာဖြင့် ဖြည့်ပါ',
                'ne' => 'म्यानमारमा सन्देश शीर्षक प्रविष्ट गर्नुहोस्'
            ],
            'enter_the_message_title_in_nepali' => [
                'en' => 'Enter the message title in Nepali',
                'mm' => 'အသိပေးချက်ခေါင်းစဉ်ကို နီပေါစာဖြင့် ဖြည့်ပါ',
                'ne' => 'सन्देशको शीर्षक नेपालीमा प्रविष्ट गर्नुहोस्।'
            ],
            'enter_the_message_body_in_english' => [
                'en' => 'Enter the message body in English',
                'mm' => 'အသိပေးချက်စာကိုယ်ကို အင်္ဂလိပ်စာဖြင့် ဖြည့်ပါ',
                'ne' => 'सन्देशको मुख्य भाग अंग्रेजीमा प्रविष्ट गर्नुहोस्।'
            ],
            'enter_the_message_body_in_myanmar' => [
                'en' => 'Enter the message body in Myanamr',
                'mm' => 'အသိပေးချက်စာကိုယ်ကို မြန်မာစာဖြင့် ဖြည့်ပါ',
                'ne' => 'म्यानमारमा सन्देशको मुख्य भाग प्रविष्ट गर्नुहोस्।'
            ],
            'enter_the_message_body_in_nepali' => [
                'en' => 'Enter the message body in Nepali',
                'mm' => 'အသိပေးချက်စာကိုယ်ကို နီပေါစာဖြင့် ဖြည့်ပါ',
                'ne' => 'सन्देशको शीर्षक नेपालीमा प्रविष्ट गर्नुहोस्।'
            ],
            'english' => [
                'en' => 'English',
                'mm' => 'အင်္ဂလိပ်',
                'ne' => 'अंग्रेजी'
            ],
            'nepali' => [
                'en' => 'Neapli',
                'mm' => 'နီပေါ',
                'ne' => 'नेपाली'
            ],
            'myanmar' => [
                'en' => 'Myanmar',
                'mm' => 'မြန်မာ',
                'ne' => 'म्यानमार'
            ],
            'destroy' => [
                'en' => 'Destroy',
                'mm' => 'ဖျက်ရန်',
                'ne' => 'नष्ट गर्नुहोस्'
            ]
        ];

        foreach ($words as $word => $translations) {
            \App\Models\SystemLanguageWord::firstOrCreate([
                'word' => $word
            ]);
        }

        $langs = SystemLanguage::all();

        foreach ($langs as $lang) {
            // if ($lang->locale !== 'ne') {
            foreach ($words as $word => $translations) {
                SystemLanguageTranslation::firstOrCreate([
                    'system_language_id' => $lang->id,
                    'system_language_word_id' => \App\Models\SystemLanguageWord::where('word', $word)->first()->id,
                    'translation' => $translations[$lang->locale]
                ]);
            }
            // }
        }
    }
}
