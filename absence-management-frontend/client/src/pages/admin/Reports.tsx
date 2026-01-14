import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function AdminReports() {
  return (
    <ProtectedRoute allowedRoles={['admin']}>
      <DashboardLayout
        title="Reports & Analytics"
        description="View detailed reports and analytics"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Reports and analytics features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
