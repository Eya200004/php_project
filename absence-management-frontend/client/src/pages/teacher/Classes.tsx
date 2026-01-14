import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function TeacherClasses() {
  return (
    <ProtectedRoute allowedRoles={['enseignant']}>
      <DashboardLayout
        title="My Classes"
        description="Manage your classes and students"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Class management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
