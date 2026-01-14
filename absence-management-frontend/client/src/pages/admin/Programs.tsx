import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function AdminPrograms() {
  return (
    <ProtectedRoute allowedRoles={['admin']}>
      <DashboardLayout
        title="Program Management"
        description="Manage academic programs and filières"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Program management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
