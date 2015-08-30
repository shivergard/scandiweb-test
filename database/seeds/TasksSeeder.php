<?php
use Illuminate\Database\Seeder;
use ScandiWebTest\Task;

/**
 * Tasks Seeder
 *
 * @author Roberts Sukonovs <roberts@efumo.lv>
 */
class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Task::class, 14)->create();
    }

}