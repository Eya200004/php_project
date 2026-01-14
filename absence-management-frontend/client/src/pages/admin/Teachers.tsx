import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function AdminTeachers() {
  return (
    <ProtectedRoute allowedRoles={['admin']}>
      <DashboardLayout
        title="Teacher Management"
        description="Manage teachers and their assignments"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Teacher management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
