import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function TeacherDocuments() {
  return (
    <ProtectedRoute allowedRoles={['enseignant']}>
      <DashboardLayout
        title="Course Documents"
        description="Upload and manage course materials"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Document management features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
