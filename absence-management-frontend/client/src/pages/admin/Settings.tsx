import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function AdminSettings() {
  return (
    <ProtectedRoute allowedRoles={['admin']}>
      <DashboardLayout
        title="Settings"
        description="Manage system settings and configuration"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Settings features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
