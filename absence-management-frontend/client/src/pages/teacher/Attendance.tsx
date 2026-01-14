import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function TeacherAttendance() {
  return (
    <ProtectedRoute allowedRoles={['enseignant']}>
      <DashboardLayout
        title="Attendance Management"
        description="Track and manage student attendance"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Attendance management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
