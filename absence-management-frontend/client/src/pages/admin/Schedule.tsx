import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function AdminSchedule() {
  return (
    <ProtectedRoute allowedRoles={['admin']}>
      <DashboardLayout
        title="Schedule Management"
        description="Manage class schedules and timetables"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Schedule management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
