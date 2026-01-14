import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function StudentSettings() {
  return (
    <ProtectedRoute allowedRoles={['etudiant']}>
      <DashboardLayout
        title="Settings"
        description="Manage your profile and preferences"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Settings features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
