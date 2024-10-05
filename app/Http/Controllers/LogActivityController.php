<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = LogActivity::query();

        if ($request->has('action') && $request->action != '') {
            $query->where('action', $request->action);
        }

        if ($request->has('content_type') && $request->content_type != '') {
            $query->where('content_type', $request->content_type);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logActivities = $query->paginate(10);

        $actions = LogActivity::select('action')->distinct()->get();
        $contentTypes = LogActivity::select('content_type')->distinct()->get();

        return view('log_activities.index', compact('logActivities', 'actions', 'contentTypes'));
    }
}
