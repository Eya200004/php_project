import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function AdminModules() {
  return (
    <ProtectedRoute allowedRoles={['admin']}>
      <DashboardLayout
        title="Module Management"
        description="Manage modules and course assignments"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Module management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
