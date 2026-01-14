import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function TeacherModules() {
  return (
    <ProtectedRoute allowedRoles={['enseignant']}>
      <DashboardLayout
        title="My Modules"
        description="Manage your assigned modules"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Module management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
