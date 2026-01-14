import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';
import { AlertCircle, CheckCircle, XCircle, BookOpen } from 'lucide-react';
import { useState, useEffect } from 'react';

interface AbsenceStat {
  label: string;
  value: number;
  icon: React.ReactNode;
  color: string;
}

export default function StudentDashboard() {
  const [absenceStats, setAbsenceStats] = useState<AbsenceStat[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Simulate fetching absence data from backend
    setTimeout(() => {
      setAbsenceStats([
        {
          label: 'Justified Absences',
          value: 2,
          icon: <CheckCircle className="w-6 h-6" />,
          color: 'bg-green-100 text-green-600',
        },
        {
          label: 'Unjustified Absences',
          value: 3,
          icon: <XCircle className="w-6 h-6" />,
          color: 'bg-red-100 text-red-600',
        },
        {
          label: 'Total Absences',
          value: 5,
          icon: <AlertCircle className="w-6 h-6" />,
          color: 'bg-amber-100 text-amber-600',
        },
        {
          label: 'Attendance Rate',
          value: 94,
          icon: <BookOpen className="w-6 h-6" />,
          color: 'bg-blue-100 text-blue-600',
        },
      ]);
      setLoading(false);
    }, 500);
  }, []);

  return (
    <ProtectedRoute allowedRoles={['etudiant']}>
      <DashboardLayout
        title="Student Dashboard"
        description="View your absences, modules, and course materials"
      >
        {/* Absence Statistics */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          {absenceStats.map((stat, index) => (
            <Card key={index} className="p-6">
              <div className="flex items-start justify-between">
                <div>
                  <p className="text-sm font-medium text-muted-foreground mb-2">{stat.label}</p>
                  <p className="text-3xl font-bold text-foreground">
                    {stat.value}{stat.label === 'Attendance Rate' ? '%' : ''}
                  </p>
                </div>
                <div className={`p-3 rounded-lg ${stat.color}`}>{stat.icon}</div>
              </div>
            </Card>
          ))}
        </div>

        {/* Main Content */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* My Modules */}
          <Card className="lg:col-span-2 p-6">
            <h3 className="text-lg font-bold text-foreground mb-4">My Modules</h3>
            <div className="space-y-4">
              {[
                { name: 'Data Structures', teacher: 'Prof. Ahmed Alaoui', progress: 75 },
                { name: 'Web Development', teacher: 'Prof. Fatima Bennani', progress: 82 },
                { name: 'Database Design', teacher: 'Prof. Mohammed Chraibi', progress: 68 },
              ].map((module, index) => (
                <div key={index} className="pb-4 border-b border-border last:border-b-0">
                  <div className="flex justify-between items-start mb-2">
                    <div>
                      <p className="text-sm font-semibold text-foreground">{module.name}</p>
                      <p className="text-xs text-muted-foreground">{module.teacher}</p>
                    </div>
                    <span className="text-xs font-bold text-primary">{module.progress}%</span>
                  </div>
                  <div className="w-full bg-secondary rounded-full h-2">
                    <div
                      className="bg-primary h-2 rounded-full transition-all duration-300"
                      style={{ width: `${module.progress}%` }}
                    ></div>
                  </div>
                </div>
              ))}
            </div>
          </Card>

          {/* Quick Links */}
          <Card className="p-6">
            <h3 className="text-lg font-bold text-foreground mb-4">Quick Links</h3>
            <div className="space-y-3">
              <button className="w-full py-2.5 px-4 bg-primary hover:opacity-90 text-white rounded-lg font-medium transition-all duration-150 text-sm">
                View Absences
              </button>
              <button className="w-full py-2.5 px-4 bg-secondary hover:bg-muted text-foreground rounded-lg font-medium transition-all duration-150 text-sm">
                Download Materials
              </button>
              <button className="w-full py-2.5 px-4 bg-secondary hover:bg-muted text-foreground rounded-lg font-medium transition-all duration-150 text-sm">
                View Announcements
              </button>
              <button className="w-full py-2.5 px-4 bg-secondary hover:bg-muted text-foreground rounded-lg font-medium transition-all duration-150 text-sm">
                My Profile
              </button>
            </div>
          </Card>
        </div>

        {/* Announcements */}
        <Card className="p-6 mt-6">
          <h3 className="text-lg font-bold text-foreground mb-4">Recent Announcements</h3>
          <div className="space-y-4">
            {[
              {
                title: 'Exam Schedule Released',
                module: 'Data Structures',
                date: '2 hours ago',
              },
              {
                title: 'Assignment Deadline Extended',
                module: 'Web Development',
                date: '1 day ago',
              },
              {
                title: 'New Course Materials Available',
                module: 'Database Design',
                date: '2 days ago',
              },
            ].map((announcement, index) => (
              <div key={index} className="flex items-start gap-4 pb-4 border-b border-border last:border-b-0">
                <div className="w-2 h-2 bg-primary rounded-full mt-2 flex-shrink-0"></div>
                <div className="flex-1">
                  <p className="text-sm font-semibold text-foreground">{announcement.title}</p>
                  <p className="text-xs text-muted-foreground">
                    {announcement.module} • {announcement.date}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
