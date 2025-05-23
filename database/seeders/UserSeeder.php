<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['Jill Hamza', 'jill', 1, 'Jill is a creative and driven individual known for her passion for problem-solving and innovation. With a knack for organization and detail, she thrives in fast-paced environments. Outside work, Jill enjoys hiking, reading, listening to metal bands like Architects and Poppy, and exploring new cuisines.'],
            ['Mai Rosalind', 'mai', 2, 'Mai is an analytical thinker and a lifelong learner, constantly seeking ways to improve and grow. She has a talent for connecting with people and building meaningful relationships. In her free time, Mai loves painting, gardening, and spending time with her family.'],
            ['Ronald Dacey', 'ron', 3, 'Ron is a resourceful and dependable professional with a background in leadership and project management. He’s known for his quick wit and ability to inspire others. Ron enjoys woodworking, playing chess, and volunteering at his local community center.'],
            ['Sebastian Picasco', 'seb', 4, 'Sebastian is a passionate and results-oriented individual with a love for tackling challenges head-on. He has a sharp eye for detail and excels in strategic planning. When not working, Sebastian enjoys photography, traveling, and discovering local music scenes.'],
            ['Jackie Pham', 'jackie', 5, 'Jackie is an outgoing and ambitious person, always looking to push boundaries and take on new challenges. With a talent for communication, Jackie is a natural collaborator. In her downtime, Jackie enjoys cycling, baking, and hosting game nights with friends.'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate([
                'name' => $user[0],
                'username' => $user[1],
                'email' => $user[1] . '@demo.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('demodemo'),
                'user_role_id' => $user[2],
                'movement_id' => random_int(1, 2),
                'phone_number' => '+66' . random_int(100000000, 999999999),
                'biography' => $user[3],
            ]);
        }
    }
}
