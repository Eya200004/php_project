import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function StudentModules() {
  return (
    <ProtectedRoute allowedRoles={['etudiant']}>
      <DashboardLayout
        title="My Modules"
        description="View your enrolled modules"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Module view features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
