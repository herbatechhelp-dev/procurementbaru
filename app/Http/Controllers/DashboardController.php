<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Approval;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            $stats = $this->getSuperadminStats();
            $recentPRs = PurchaseRequest::with(['user', 'department'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            $chartData = $this->getSuperadminChartData();
        } elseif ($user->hasRole('user')) {
            $stats = $this->getUserStats($user);
            $recentPRs = PurchaseRequest::where('user_id', $user->id)
                ->with(['user', 'department'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            $chartData = $this->getUserChartData($user);
        } else {
            $stats = $this->getManagerStats($user);
            $recentPRs = PurchaseRequest::with(['user', 'department'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            $chartData = $this->getManagerChartData($user);
        }

        return view('dashboard', compact('stats', 'recentPRs', 'chartData'));
    }

    private function getSuperadminChartData()
    {
        $prs = PurchaseRequest::all();
        return [
            'status_distribution' => $this->formatStatusDistribution($prs),
            'monthly_trends' => $this->getMonthlyTrends(),
        ];
    }

    private function getUserChartData($user)
    {
        $prs = PurchaseRequest::where('user_id', $user->id)->get();
        return [
            'status_distribution' => $this->formatStatusDistribution($prs),
            'monthly_trends' => $this->getMonthlyTrends($user->id),
        ];
    }

    private function getManagerChartData($user)
    {
        $prs = PurchaseRequest::all();
        return [
            'status_distribution' => $this->formatStatusDistribution($prs),
            'monthly_trends' => $this->getMonthlyTrends(),
        ];
    }

    private function formatStatusDistribution($prs)
    {
        $counts = [
            'Draft' => 0,
            'Pending' => 0,
            'Revision Required' => 0,
            'Processing' => 0,
            'Completed' => 0
        ];

        foreach($prs as $pr) {
            $status = $pr->approval_status;
            if ($status === 'Draft') $counts['Draft']++;
            elseif ($status === 'Pending') $counts['Pending']++;
            elseif ($status === 'Revision Required' || $status === 'Partial / Revision') $counts['Revision Required']++;
            elseif ($status === 'Completed') $counts['Completed']++;
            else $counts['Processing']++;
        }

        return [
            'labels' => array_keys($counts),
            'data' => array_values($counts)
        ];
    }

    private function getMonthlyTrends($userId = null)
    {
        $months = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            
            $query = PurchaseRequest::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year);
            
            if ($userId) {
                $query->where('user_id', $userId);
            }
            
            $data[] = $query->count();
        }

        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    private function getSuperadminStats()
    {
        $prs = PurchaseRequest::with('items')->get();
        return [
            'total_pr' => $prs->count(),
            'total_users' => User::count(),
            'total_departments' => Department::count(),
            'pending_pr' => $prs->filter(fn($p) => in_array($p->approval_status, ['Pending', 'Revision Required', 'Partial / Revision']))->count(),
            'approved_pr' => $prs->filter(fn($p) => !in_array($p->approval_status, ['Draft', 'Pending', 'Revision Required', 'Partial / Revision', 'Completed']))->count(),
            'rejected_pr' => $prs->filter(fn($p) => in_array($p->approval_status, ['Revision Required', 'Partial / Revision']))->count(),
        ];
    }

    private function getUserStats($user)
    {
        $prs = PurchaseRequest::where('user_id', $user->id)->with('items')->get();
        return [
            'my_pr' => $prs->count(),
            'pending_pr' => $prs->filter(fn($p) => in_array($p->approval_status, ['Pending', 'Revision Required', 'Partial / Revision']))->count(),
            'approved_pr' => $prs->filter(fn($p) => !in_array($p->approval_status, ['Draft', 'Pending', 'Revision Required', 'Partial / Revision', 'Completed']))->count(),
            'rejected_pr' => $prs->filter(fn($p) => in_array($p->approval_status, ['Revision Required', 'Partial / Revision']))->count(),
            'draft_pr' => $prs->filter(fn($p) => $p->approval_status === 'Draft')->count(),
        ];
    }

    private function getManagerStats($user)
    {
        $role = $user->getRoleNames()->first();
        $prs = PurchaseRequest::with('items')->get();
        
        // Items where current status matches what this manager should review
        $pendingTarget = match($role) {
            'operational_manager' => 'Pending',
            'general_manager' => 'Approved (OM)',
            'procurement' => 'Approved (GM)',
            default => 'Pending'
        };

        return [
            'pr_to_review' => $prs->filter(function($p) use ($pendingTarget) {
                // For managers, we check if they have ANY item to review in this PR
                // even if the overall PR status is "Partial / Revision"
                return $p->approval_status === $pendingTarget || 
                       ($p->approval_status === 'Partial / Revision' && $p->items->contains('status', strtolower(str_replace(['Approved (', ')'], '', $pendingTarget))));
            })->count(),
            'total_pr' => $prs->count(),
            'approved_today' => Approval::where('approver_id', $user->id)
                ->whereDate('approved_at', today())
                ->count(),
            'rejected_today' => Approval::where('approver_id', $user->id)
                ->where('status', 'rejected')
                ->whereDate('approved_at', today())
                ->count(),
        ];
    }
}