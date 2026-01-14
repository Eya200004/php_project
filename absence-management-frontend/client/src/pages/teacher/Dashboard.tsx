import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';
import { Users, BookOpen, BarChart3, TrendingUp } from 'lucide-react';
import { useState, useEffect } from 'react';

interface KPI {
  label: string;
  value: number | string;
  change?: string;
  icon: React.ReactNode;
  color: string;
}

export default function TeacherDashboard() {
  const [kpis, setKpis] = useState<KPI[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Simulate fetching KPI data from backend
    setTimeout(() => {
      setKpis([
        {
          label: 'My Modules',
          value: 4,
          change: 'This semester',
          icon: <BookOpen className="w-6 h-6" />,
          color: 'bg-blue-100 text-blue-600',
        },
        {
          label: 'Total Students',
          value: 156,
          change: 'Across all modules',
          icon: <Users className="w-6 h-6" />,
          color: 'bg-green-100 text-green-600',
        },
        {
          label: 'Avg Attendance',
          value: '88.3%',
          change: '+2.1% from last week',
          icon: <BarChart3 className="w-6 h-6" />,
          color: 'bg-amber-100 text-amber-600',
        },
        {
          label: 'Pending Tasks',
          value: 5,
          change: 'Documents to grade',
          icon: <TrendingUp className="w-6 h-6" />,
          color: 'bg-purple-100 text-purple-600',
        },
      ]);
      setLoading(false);
    }, 500);
  }, []);

  return (
    <ProtectedRoute allowedRoles={['enseignant']}>
      <DashboardLayout
        title="Teacher Dashboard"
        description="Overview of your modules, classes, and attendance"
      >
        {/* KPI Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          {kpis.map((kpi, index) => (
            <Card key={index} className="p-6">
              <div className="flex items-start justify-between">
                <div>
                  <p className="text-sm font-medium text-muted-foreground mb-2">{kpi.label}</p>
                  <p className="text-3xl font-bold text-foreground">{kpi.value}</p>
                  {kpi.change && (
                    <p className="text-xs text-muted-foreground mt-2">{kpi.change}</p>
                  )}
                </div>
                <div className={`p-3 rounded-lg ${kpi.color}`}>{kpi.icon}</div>
              </div>
            </Card>
          ))}
        </div>

        {/* Main Content */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Upcoming Sessions */}
          <Card className="lg:col-span-2 p-6">
            <h3 className="text-lg font-bold text-foreground mb-4">Upcoming Sessions</h3>
            <div className="space-y-4">
              {[
                { module: 'Data Structures', time: 'Today at 10:00 AM', class: 'GIIA-S3' },
                { module: 'Web Development', time: 'Tomorrow at 2:00 PM', class: 'GMSI-S5' },
                { module: 'Database Design', time: 'Wed at 9:00 AM', class: 'GPMA-S4' },
              ].map((session, index) => (
                <div key={index} className="flex items-center gap-4 pb-4 border-b border-border last:border-b-0">
                  <div className="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                    <BookOpen className="w-6 h-6 text-primary" />
                  </div>
                  <div className="flex-1">
                    <p className="text-sm font-semibold text-foreground">{session.module}</p>
                    <p className="text-xs text-muted-foreground">{session.class}</p>
                  </div>
                  <p className="text-xs font-medium text-muted-foreground">{session.time}</p>
                </div>
              ))}
            </div>
          </Card>

          {/* Quick Actions */}
          <Card className="p-6">
            <h3 className="text-lg font-bold text-foreground mb-4">Quick Actions</h3>
            <div className="space-y-3">
              <button className="w-full py-2.5 px-4 bg-primary hover:opacity-90 text-white rounded-lg font-medium transition-all duration-150 text-sm">
                Mark Attendance
              </button>
              <button className="w-full py-2.5 px-4 bg-secondary hover:bg-muted text-foreground rounded-lg font-medium transition-all duration-150 text-sm">
                Upload Document
              </button>
              <button className="w-full py-2.5 px-4 bg-secondary hover:bg-muted text-foreground rounded-lg font-medium transition-all duration-150 text-sm">
                Post Announcement
              </button>
              <button className="w-full py-2.5 px-4 bg-secondary hover:bg-muted text-foreground rounded-lg font-medium transition-all duration-150 text-sm">
                View Reports
              </button>
            </div>
          </Card>
        </div>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
