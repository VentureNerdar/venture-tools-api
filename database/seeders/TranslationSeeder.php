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
                'mm' => 'ဗန်းချား'
            ],
            'contact' => [
                'en' => 'Contact',
                'mm' => 'အဆက်အသွယ်'
            ],
            'contacts' => [
                'en' => 'Contacts',
                'mm' => 'အဆက်အသွယ်များ'
            ],
            'church' => [
                'en' => 'Church',
                'mm' => 'ဘုရားကျောင်း'
            ],
            'churches' => [
                'en' => 'Churches',
                'mm' => 'ဘုရားကျောင်းများ'
            ],
            'community' => [
                'en' => 'Community',
                'mm' => 'အသိုင်းအ၀ိုင်း'
            ],
            'communities' => [
                'en' => 'Communities',
                'mm' => 'အသိုင်းအ၀ိုင်းများ',
            ],
            'settings' => [
                'en' => 'Settings',
                'mm' => 'ဆက်တင်များ'
            ],
            'user' => [
                'en' => 'User',
                'mm' => 'အသုံးပြုသူ'
            ],
            'users' => [
                'en' => 'Users',
                'mm' => 'အသုံးပြုသူများ'
            ],
            'configuration' => [
                'en' => 'Configuration',
                'mm' => 'ဖွဲ့စည်းမှု'
            ],
            'configurations' => [
                'en' => 'Configurations',
                'mm' => 'ဖွဲ့စည်းမှုများ'
            ],
            'translation' => [
                'en' => 'Translation',
                'mm' => 'ဘာသာပြန်ချက်'
            ],
            'translations' => [
                'en' => 'Translations',
                'mm' => 'ဘာသာပြန်ချက်များ'
            ],
            'language' => [
                'en' => 'Language',
                'mm' => 'ဘာသာစကား'
            ],
            'languages' => [
                'en' => 'Languages',
                'mm' => 'ဘာသာစကားများ'
            ],

            // Actions
            'create' => [
                'en' => 'Create',
                'mm' => 'ဖန်တီး'
            ],
            'edit' => [
                'en' => 'Edit',
                'mm' => 'ပြုပြင်'
            ],
            'list' => [
                'en' => 'List',
                'mm' => 'စာရင်း'
            ],
            'view' => [
                'en' => 'View',
                'mm' => 'ကြည့်ရှု'
            ],
            'delete' => [
                'en' => 'Delete',
                'mm' => 'ဖျက်ပစ်'
            ],
            'name' => [
                'en' => 'Name',
                'mm' => 'နာမည်'
            ],
            'label' => [
                'en' => 'Label',
                'mm' => 'လေဘယ်'
            ],
            'locale' => [
                'en' => 'Locale',
                'mm' => '‌ဒေသဘာသာ'
            ],
            'active_status' => [
                'en' => 'Active Status',
                'mm' => 'လက်ရှိအခြေအနေ'
            ],
            'is_enabled' => [
                'en' => 'Is Enabled',
                'mm' => 'ဖွင့်ထားသည်'
            ],
            'save' => [
                'en' => 'Save',
                'mm' => 'သိမ်းဆည်း'
            ],
            'save_changes' => [
                'en' => 'Save Changes',
                'mm' => 'ပြောင်းလဲမှုများသိမ်းဆည်း'
            ],
            'cancel' => [
                'en' => 'Cancel',
                'mm' => 'ပယ်ဖျက်သည်'
            ],
            'sign_out' => [
                'en' => 'Sign Out',
                'mm' => 'ထွက်'
            ],

            // Language
            'language_information' => [
                'en' => 'Language Information',
                'mm' => 'ဘာသာစကားအချက်အလက်'
            ],
            'edit_language' => [
                'en' => 'Edit Language',
                'mm' => 'ဘာသာစကားပြုပြင်'
            ],
            'create_language' => [
                'en' => 'Create Language',
                'mm' => 'ဘာသာစကားဖန်တီး'
            ],
            'save_language_information' => [
                'en' => 'Save Language Information',
                'mm' => 'ဘာသာစကားအချက်အလက်သိမ်းဆည်း'
            ],

            'save_translation' => [
                'en' => 'Save Translation',
                'mm' => 'ဘာသာပြန်ချက်သိမ်းဆည်း'
            ],

            'user_roles' => [
                'en' => 'User Roles',
                'mm' => 'အသုံးပြုသူအခန်းကဏ္ဍ'
            ],

            'all_roles' => [
                'en' => 'All Roles',
                'mm' => 'အခန်းကဏ္ဍအားလုံး'
            ],

            'add_user' => [
                'en' => 'Add User',
                'mm' => 'အသုံးပြုသူထည့်သွင်းပါ'
            ],

            'search' => [
                'en' => 'Search',
                'mm' => 'ရှာဖွေပါ'
            ],

            'add_contact' => [
                'en' => 'Add Contact',
                'mm' => 'အဆက်အသွယ်ထည့်သွင်းပါ'
            ],

            'no_data' => [
                'en' => 'No Data',
                'mm' => 'အချက်အလက်မရှိပါ'
            ],

            'contact_status' => [
                'en' => 'Contact Status',
                'mm' => 'အဆက်အသွယ်အခြေအနေ'
            ],

            'faith_status' => [
                'en' => 'Faith Status',
                'mm' => 'ယုံကြည်ခြင်းအခြေအနေ'
            ],

            'assigned_to' => [
                'en' => 'Assigned To',
                'mm' => 'တာဝန်ပေးထားသူ'
            ],

            'coached_by' => [
                'en' => 'Coached By',
                'mm' => 'သင်ကြားပေးသူ'
            ],

            'basic_information' => [
                'en' => 'Basic Information',
                'mm' => 'အခြေခံအချက်အလက်'
            ],

            'faith' => [
                'en' => 'Faith',
                'mm' => 'ယုံကြည်ခြင်း'
            ],

            'contact_information' => [
                'en' => 'Contact Information',
                'mm' => 'အဆက်အသွယ်အချက်အလက်'
            ],

            'baptism' => [
                'en' => 'Baptism',
                'mm' => 'ဗတ္တိဇံ'
            ],

            'current_prayers' => [
                'en' => 'Current Prayers',
                'mm' => 'လက်ရှိဆုတောင်းချက်များ'
            ],

            'select_a_status' => [
                'en' => 'Select a Status',
                'mm' => 'အခြေအနေရွေးပါ'
            ],

            'nickname' => [
                'en' => 'Nickname',
                'mm' => 'အိမ်ခေါ်နာမည်'
            ],

            'gender' => [
                'en' => 'Gender',
                'mm' => 'ကျား/မ'
            ],

            'age' => [
                'en' => 'Age',
                'mm' => 'အသက်'
            ],

            'people_group' => [
                'en' => 'People Group',
                'mm' => 'လူမျိုးအုပ်စု'
            ],

            'baptism_date' => [
                'en' => 'Baptism Date',
                'mm' => 'ဗတ္တိဇံခံယူသည့်ရက်'
            ],

            'select_an_option' => [
                'en' => 'Select an Option',
                'mm' => 'ရွေးချယ်မှုတစ်ခုကို ရွေးချယ်ပါ။'
            ],

            'male' => [
                'en' => 'Male',
                'mm' => 'ကျား'
            ],

            'female' => [
                'en' => 'female',
                'mm' => 'မ'
            ],

            'add_multiple_contact_information_for_each_platform' => [
                'en' => 'Add multiple contact information for each platform',
                'mm' => 'တစ်ခုအတွင်းအဆက်အသွယ်အချက်အလက်များထည့်သွင်းပါ'
            ],

            'faith_milestones' => [
                'en' => 'Faith Milestones',
                'mm' => 'ယုံကြည်ခြင်းမှတ်တိုင်များ'
            ],

            'baptized_by' => [
                'en' => 'Baptized By',
                'mm' => 'နှစ်ခြင်းပေးသူ'
            ],

            'baptized_people' => [
                'en' => 'Baptized People',
                'mm' => 'နှစ်ခြင်းပေးထားသူများ'
            ],

            'add' => [
                'en' => 'Add',
                'mm' => 'ထည့်သွင်းရန်'
            ],

            'add_baptized_person' => [
                'en' => 'Add Baptized Person',
                'mm' => 'နှစ်ခြင်းပေးထားသူထည့်သွင်းပါ'
            ],

            'track_and_manage_ongoing_prayer_requests_or_intentions_here' => [
                'en' => 'Track and manage ongoing prayer requests or intentions here',
                'mm' => 'လက်ရှိဆုတောင်းချက်များ သို့မဟုတ် ရည်ရွယ်ချက်များကို ဤနေရာတွင် ခြေရာခံပြီး စီမံပါ။'
            ],

            'enter_current_prayers' => [
                'en' => 'Enter current prayers',
                'mm' => 'လက်ရှိဆုတောင်းချက်များထည့်သွင်းပါ'
            ],

            'create_and_create_another' => [
                'en' => 'Create and Create Another',
                'mm' => 'ဖန်တီးပြီး နောက်တစ်ခု ဖန်တီးပါ။'
            ],

            'create_contact' => [
                'en' => 'Create Contact',
                'mm' => 'အဆက်အသွယ်ဖန်တီး'
            ]
        ];

        foreach ($words as $word => $translations) {
            \App\Models\SystemLanguageWord::firstOrCreate([
                'word' => $word
            ]);
        }

        $langs = SystemLanguage::all();

        foreach ($langs as $lang) {
            if ($lang->locale !== 'ne') {
                foreach ($words as $word => $translations) {
                    SystemLanguageTranslation::create([
                        'system_language_id' => $lang->id,
                        'system_language_word_id' => \App\Models\SystemLanguageWord::where('word', $word)->first()->id,
                        'translation' => $translations[$lang->locale]
                    ]);
                }
            }
        }
    }
}
