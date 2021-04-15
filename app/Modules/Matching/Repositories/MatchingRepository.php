<?php

namespace App\Modules\Macthing\Repositories;

use App\Modules\Matching\Interfaces\MatchingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectModel;


class MatchingRepository implements MatchingRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $projectModel;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     */
    public function __construct(ProjectModel $projectModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->projectModel = $projectModel;
    }
}
